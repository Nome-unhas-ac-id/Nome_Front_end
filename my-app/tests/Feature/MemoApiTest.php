<?php

namespace Tests\Feature;

use App\Jobs\ProcessAudio;
use App\Models\AudioJob;
use App\Models\Memo;
use App\Models\User;
use App\Services\SummaryHtml;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MemoApiTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        return $user;
    }

    private function audio(): UploadedFile
    {
        $samples = str_repeat("\0", 1600);
        $wav = 'RIFF'.pack('V', 36 + strlen($samples)).'WAVEfmt '.pack('VvvVVvv', 16, 1, 1, 8000, 16000, 2, 16).'data'.pack('V', strlen($samples)).$samples;

        return UploadedFile::fake()->createWithContent('meeting.wav', $wav);
    }

    private function aiConfig(): void
    {
        config(['services.nome.url' => 'https://ai.test/submit', 'services.nome.webhook_secret' => 'test-secret']);
    }

    private function sendCallback(array $data, bool $signed = true): TestResponse
    {
        $body = json_encode($data, JSON_UNESCAPED_UNICODE);

        return $this->call('POST', '/api/webhooks/nome-callback', [], [], [], [
            'CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_WEBHOOK_SIGNATURE' => $signed ? hash_hmac('sha256', $body, 'test-secret') : 'invalid',
        ], $body);
    }

    public function test_login_returns_expiring_token_without_roles_and_logout_revokes_it(): void
    {
        $user = User::factory()->create();
        $login = $this->postJson('/api/auth/login', ['email' => $user->email, 'password' => 'password'])
            ->assertOk()->assertJsonPath('success', true)->assertJsonMissingPath('data.user.role');
        $token = $login->json('data.token');
        $this->assertNotEmpty($login->json('data.expires_at'));
        $this->withToken($token)->getJson('/api/auth/me')->assertOk()->assertJsonPath('data.id', $user->id);
        $this->postJson('/api/auth/logout')->assertOk();
        Auth::forgetGuards();
        $this->getJson('/api/auth/me')->assertUnauthorized()->assertJsonPath('success', false);
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_invalid_and_expired_credentials_are_rejected(): void
    {
        $user = User::factory()->create();
        $this->postJson('/api/auth/login', ['email' => $user->email, 'password' => 'wrong'])->assertUnauthorized();
        $this->postJson('/api/auth/login', [])->assertUnprocessable()->assertJsonStructure(['errors' => ['email', 'password']]);
        $expired = $user->createToken('expired', ['*'], now()->subMinute());
        $this->withToken($expired->plainTextToken)->getJson('/api/memos')->assertUnauthorized();
    }

    public function test_login_rate_limit_returns_retry_after(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/auth/login', ['email' => 'throttle@test.com', 'password' => 'wrong'])->assertUnauthorized();
        }
        $this->postJson('/api/auth/login', ['email' => 'throttle@test.com', 'password' => 'wrong'])
            ->assertStatus(429)->assertHeader('Retry-After')->assertJsonPath('success', false);
    }

    public function test_guest_cannot_read_or_create_memos(): void
    {
        $this->getJson('/api/memos')->assertUnauthorized()->assertJsonPath('data', null);
        $this->postJson('/api/memos', ['title' => 'X', 'meeting_date' => '2026-11-10'])->assertUnauthorized();
    }

    public function test_create_and_list_include_the_frontend_fields(): void
    {
        $this->user();
        $created = $this->postJson('/api/memos', [
            'title' => 'Rapat Integrasi', 'meeting_date' => '2026-11-10', 'meeting_time' => '09:30',
            'meeting_end_time' => '11:00', 'agenda' => 'Agenda tersimpan',
            'letter' => ['letter_number' => '005/TEST', 'signer_name' => 'Andi'],
            'attendees' => [['name' => 'Budi', 'agency_or_position' => 'Kominfo']],
        ])->assertCreated()->assertJsonPath('data.status', 'draft')->assertJsonPath('data.agenda', 'Agenda tersimpan');
        $id = $created->json('data.id');
        $this->assertMatchesRegularExpression('/^[0-9a-f-]{36}$/', $id);
        $this->getJson('/api/memos')->assertOk()->assertJsonPath('data.items.0.letter_number', '005/TEST')
            ->assertJsonPath('data.items.0.attendees_count', 1)->assertJsonPath('data.items.0.meeting_end_time', '11:00')
            ->assertJsonMissingPath('data.items.0.summary_text')->assertJsonMissingPath('data.items.0.ai_raw_json');
        $this->getJson('/api/memos/'.$id.'/preview')->assertOk()->assertJsonPath('data.memo.agenda', 'Agenda tersimpan')
            ->assertJsonPath('data.memo.meeting_time_label', '09:30 WITA')->assertJsonPath('data.can_export', false);
    }

    public function test_update_returns_new_values_and_preserves_omitted_fields(): void
    {
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create(['letter' => ['letter_number' => 'ABC', 'signer_name' => 'Andi'], 'attendees' => [['name' => 'Budi'], ['name' => 'Rina']]]);
        $this->putJson('/api/memos/'.$memo->id, [
            'title' => 'Revisi', 'summary_text' => '<p onclick="bad()">A &amp; B</p><script>alert(1)</script>',
            'attendees' => [['name' => 'Budi']], 'version' => 1,
        ])->assertOk()->assertJsonPath('data.title', 'Revisi')->assertJsonCount(1, 'data.attendees')
            ->assertJsonPath('data.letter.letter_number', 'ABC')->assertJsonPath('data.version', 2);
        $this->assertStringNotContainsString('script', $memo->fresh()->summary_text);
        $this->assertStringNotContainsString('onclick', $memo->fresh()->summary_text);
        $this->putJson('/api/memos/'.$memo->id, ['letter' => ['signer_name' => 'Siti']])
            ->assertOk()->assertJsonPath('data.letter.letter_number', 'ABC')->assertJsonPath('data.letter.signer_name', 'Siti');
        $this->putJson('/api/memos/'.$memo->id, ['letter' => null, 'attendees' => []])
            ->assertOk()->assertJsonPath('data.letter', null)->assertJsonCount(0, 'data.attendees');
    }

    public function test_version_conflicts_and_processing_edits_are_rejected(): void
    {
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create(['version' => 3]);
        $this->putJson('/api/memos/'.$memo->id, ['title' => 'Conflict', 'version' => 2])->assertStatus(409);
        $memo->update(['status' => 'processing']);
        $this->putJson('/api/memos/'.$memo->id, ['title' => 'No'])->assertStatus(409);
        $this->deleteJson('/api/memos/'.$memo->id)->assertStatus(409);
    }

    public function test_search_filters_pagination_and_optional_date_to(): void
    {
        $user = $this->user();
        Memo::factory()->for($user)->count(3)->create(['title' => 'Koordinasi', 'status' => 'completed']);
        Memo::factory()->for($user)->create(['title' => 'Lainnya']);
        Memo::factory()->create(['title' => 'Koordinasi', 'status' => 'completed']);
        $this->getJson('/api/memos?search=Koordinasi&status=completed&per_page=2&page=2')
            ->assertOk()->assertJsonCount(1, 'data.items')->assertJsonPath('data.meta.total', 3)->assertJsonPath('data.meta.last_page', 2);
        $this->getJson('/api/memos?date_to=2026-12-01')->assertOk();
        $this->getJson('/api/memos?date_from=2026-12-01&date_to=2026-01-01')->assertUnprocessable();
    }

    public function test_validation_rejects_invalid_metadata_and_summary_on_create(): void
    {
        $this->user();
        $this->postJson('/api/memos', ['title' => '', 'meeting_date' => '2026-02-30', 'meeting_time' => '25:00', 'summary_text' => 'not allowed'])
            ->assertUnprocessable()->assertJsonStructure(['errors' => ['title', 'meeting_date', 'meeting_time', 'summary_text']]);
        $this->getJson('/api/memos?per_page=51&status=review')->assertUnprocessable();
    }

    public function test_valid_audio_is_private_queued_and_conflicting_uploads_are_rejected(): void
    {
        Queue::fake();
        Storage::fake('local');
        $this->aiConfig();
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create();
        $response = $this->post('/api/memos/'.$memo->id.'/upload-audio', ['audio' => $this->audio()], ['Accept' => 'application/json'])
            ->assertStatus(202)->assertJsonPath('data.status', 'processing');
        $job = AudioJob::findOrFail($response->json('data.job_id'));
        Storage::disk('local')->assertExists($job->path);
        Queue::assertPushed(ProcessAudio::class, fn (ProcessAudio $queued) => $queued->audioJobId === $job->id);
        $this->getJson('/api/memos/'.$memo->id.'/status')->assertOk()->assertJsonPath('data.audio_job.job_id', $job->id);
        $this->post('/api/memos/'.$memo->id.'/upload-audio', ['audio' => $this->audio()], ['Accept' => 'application/json'])->assertStatus(409);
        $this->assertDatabaseCount('audio_jobs', 1);
        $this->assertCount(1, Storage::disk('local')->allFiles());
    }

    public function test_upload_rejects_bad_files_and_missing_ai_configuration_without_changing_memo(): void
    {
        Storage::fake('local');
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create();
        $this->post('/api/memos/'.$memo->id.'/upload-audio', ['audio' => UploadedFile::fake()->createWithContent('wrong.mp3', 'not audio')->mimeType('text/plain')], ['Accept' => 'application/json'])->assertUnprocessable();
        config(['services.nome.url' => null]);
        $this->post('/api/memos/'.$memo->id.'/upload-audio', ['audio' => $this->audio()], ['Accept' => 'application/json'])->assertStatus(503);
        $this->assertSame('draft', $memo->fresh()->status);
        $this->assertCount(0, Storage::disk('local')->allFiles());
    }

    public function test_signed_completion_updates_preview_and_duplicate_callbacks_do_not_overwrite_edits(): void
    {
        $this->aiConfig();
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create(['status' => 'processing']);
        $job = AudioJob::factory()->for($memo)->create();
        $memo->update(['latest_audio_job_id' => $job->id]);
        $data = ['job_id' => $job->id, 'status' => 'completed', 'structured_minutes' => "## Ringkasan\n- Keputusan tim", 'transcript' => 'Transkrip asli'];
        $this->sendCallback($data, false)->assertUnauthorized();
        $this->sendCallback($data)->assertOk()->assertJsonPath('data.status', 'completed');
        $this->getJson('/api/memos/'.$memo->id.'/preview')->assertOk()->assertJsonPath('data.can_export', true)->assertJsonPath('data.transcript', 'Transkrip asli');
        $this->putJson('/api/memos/'.$memo->id, ['summary_text' => '<p>Koreksi pengguna</p>'])->assertOk();
        $this->sendCallback($data)->assertOk()->assertJsonPath('data', null);
        $this->assertStringContainsString('Koreksi pengguna', $memo->fresh()->summary_text);
    }

    public function test_stale_job_callbacks_and_failures_preserve_current_data(): void
    {
        $this->aiConfig();
        $memo = Memo::factory()->create(['status' => 'processing', 'summary_text' => '<p>Previous result</p>']);
        $old = AudioJob::factory()->for($memo)->create();
        $latest = AudioJob::factory()->for($memo)->create();
        $memo->update(['latest_audio_job_id' => $latest->id]);
        $this->sendCallback(['job_id' => $old->id, 'status' => 'completed', 'structured_minutes' => 'Stale'])->assertOk()->assertJsonPath('data', null);
        $this->sendCallback(['job_id' => $latest->id, 'status' => 'failed', 'error_message' => 'AI gagal'])->assertOk();
        $this->assertSame('failed', $memo->fresh()->status);
        $this->assertSame('<p>Previous result</p>', $memo->fresh()->summary_text);
        $this->sendCallback(['job_id' => $latest->id, 'status' => 'completed', 'structured_minutes' => 'Late'])->assertOk()->assertJsonPath('data', null);
    }

    public function test_worker_sends_the_documented_adapter_payload_without_exposing_webhook_secret(): void
    {
        $this->aiConfig();
        config(['services.nome.callback_url' => 'https://nome.test/api/webhooks/nome-callback']);
        Storage::fake('local');
        Storage::disk('local')->put('audio/test.wav', 'test bytes');
        Http::preventStrayRequests();
        $payload = null;
        Http::fake(function ($request) use (&$payload) {
            $payload = $request->body();

            return Http::response(['accepted' => true], 202);
        });
        $memo = Memo::factory()->create(['status' => 'processing']);
        $job = AudioJob::factory()->for($memo)->create();
        $memo->update(['latest_audio_job_id' => $job->id]);
        (new ProcessAudio($job->id))->handle();
        Http::assertSent(fn ($request) => $request->url() === 'https://ai.test/submit' && $request->hasHeader('Idempotency-Key', $job->id));
        $this->assertStringContainsString($job->id, $payload);
        $this->assertStringContainsString('https://nome.test/api/webhooks/nome-callback', $payload);
        (new ProcessAudio($job->id))->failed(new \RuntimeException('Do not expose secrets'));
        $this->assertSame('failed', $memo->fresh()->status);
        $this->assertStringNotContainsString('secrets', $memo->fresh()->error_message);
    }

    public function test_exports_require_completion_and_return_actual_pdf_and_docx(): void
    {
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create(['title' => 'Rapat A & B']);
        $this->get('/api/memos/'.$memo->id.'/export/pdf', ['Accept' => 'application/json'])->assertStatus(409);
        $memo->update(['status' => 'completed', 'summary_text' => '<h2>Ringkasan</h2><p>A &amp; B</p><ul><li>Poin</li></ul>', 'attendees' => [['name' => 'Budi & Rina']], 'letter' => ['subject' => 'Tim & Mitra']]);
        $pdf = $this->get('/api/memos/'.$memo->id.'/export/pdf')->assertOk()->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $pdf->getContent());
        $docx = $this->get('/api/memos/'.$memo->id.'/export/docx')->assertOk()->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $bytes = $docx->streamedContent();
        $this->assertStringStartsWith('PK', $bytes);
        $path = tempnam(sys_get_temp_dir(), 'nome-docx-');
        try {
            file_put_contents($path, $bytes);
            $zip = new \ZipArchive;
            $this->assertTrue($zip->open($path));
            $xml = $zip->getFromName('word/document.xml');
            $zip->close();
            $document = new \DOMDocument;
            $this->assertTrue($document->loadXML($xml, LIBXML_NONET));
            $this->assertStringContainsString('Rapat A &amp; B', $xml);
        } finally {
            unlink($path);
        }
    }

    public function test_sanitizer_preserves_safe_formatting_without_attributes_or_external_resources(): void
    {
        $clean = SummaryHtml::clean('<div><h2>Title</h2><table><tr><td style="color:red">A</td></tr></table><a href="javascript:alert(1)">Link</a><img src="file:///etc/passwd"><svg><script>bad()</script></svg><p onclick="bad()">Text</p></div>');
        $this->assertStringContainsString('<table>', $clean);
        foreach (['style=', 'onclick', '<img', '<svg', '<script', 'href=', 'file:'] as $forbidden) {
            $this->assertStringNotContainsString($forbidden, $clean);
        }
        $this->assertStringContainsString('Link', $clean);
    }

    public function test_missing_callbacks_expire_and_allow_retry(): void
    {
        $memo = Memo::factory()->create(['status' => 'processing']);
        $job = AudioJob::factory()->for($memo)->create();
        $memo->update(['latest_audio_job_id' => $job->id, 'updated_at' => now()->subHours(3)]);
        $this->artisan('nome:expire-jobs')->assertSuccessful();
        $this->assertSame('failed', $memo->fresh()->status);
        $this->assertSame('failed', $job->fresh()->status);
    }

    public function test_queue_outage_does_not_leave_a_memo_stuck_processing(): void
    {
        $this->aiConfig();
        Storage::fake('local');
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create();
        $this->mock(Dispatcher::class, function ($mock): void {
            $mock->shouldReceive('dispatch')->once()->andThrow(new \RuntimeException('Queue unavailable'));
        });
        $this->post('/api/memos/'.$memo->id.'/upload-audio', ['audio' => $this->audio()], ['Accept' => 'application/json'])
            ->assertStatus(503);
        $this->assertSame('failed', $memo->fresh()->status);
    }

    public function test_oversized_upload_is_rejected_and_empty_letter_round_trips(): void
    {
        $this->aiConfig();
        $user = $this->user();
        $memo = Memo::factory()->for($user)->create(['letter' => []]);
        $this->post('/api/memos/'.$memo->id.'/upload-audio', ['audio' => $this->audio()->size(102401)], ['Accept' => 'application/json'])
            ->assertUnprocessable();
        $response = $this->getJson('/api/memos/'.$memo->id.'/preview')->assertOk();
        $this->assertIsObject(json_decode($response->getContent())->data->letter);
        $this->putJson('/api/memos/'.$memo->id, ['version' => '1', 'letter' => ['subject' => 'Now filled']])
            ->assertOk()->assertJsonPath('data.letter.subject', 'Now filled');
    }
}
