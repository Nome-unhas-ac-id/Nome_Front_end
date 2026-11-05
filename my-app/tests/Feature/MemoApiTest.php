<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
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
        $this->withToken($expired->plainTextToken)->getJson('/api/auth/me')->assertUnauthorized();
    }

    public function test_login_rate_limit_returns_retry_after(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/auth/login', ['email' => 'throttle@test.com', 'password' => 'wrong'])->assertUnauthorized();
        }
        $this->postJson('/api/auth/login', ['email' => 'throttle@test.com', 'password' => 'wrong'])
            ->assertStatus(429)->assertHeader('Retry-After')->assertJsonPath('success', false);
    }

}
