<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_logo_image_can_be_served(): void
    {
        $response = $this->get('/images/nome-logo.png');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');
    }

    public function test_auth_routes_return_successful_responses(): void
    {
        $this->get('/login')->assertStatus(200)->assertSee('Selamat Datang');
        $this->get('/signup')->assertStatus(200)->assertSee('Buat Akun');
        $this->get('/forgot-password')->assertStatus(200)->assertSee('Lupa Kata Sandi?');
    }

    public function test_memo_form_includes_letter_fields_and_honest_draft_actions(): void
    {
        $this->get('/add-memo')
            ->assertOk()
            ->assertSee('Nomor Surat')
            ->assertSee('Pangkat Penandatangan')
            ->assertSee('Simpan Draf di Tab Ini')
            ->assertSee('Maksimal 100 MB')
            ->assertDontSee('500 MB');
    }

    public function test_local_draft_preview_does_not_show_sample_ai_results(): void
    {
        $this->get('/preview?draft=1')
            ->assertOk()
            ->assertViewIs('draft-preview')
            ->assertSee('Kembali Sunting Draf')
            ->assertDontSee('confidence_score')
            ->assertDontSee('Rapat Sinkronisasi Rencana Kerja');

        $this->get('/preview')->assertOk()->assertViewIs('preview');
    }

    public function test_history_filters_match_the_documented_processing_states(): void
    {
        $this->get('/history')
            ->assertOk()
            ->assertSee("selectedStatus = 'pending'", false)
            ->assertSee("selectedStatus = 'processing'", false)
            ->assertSee("selectedStatus = 'failed'", false)
            ->assertDontSee('selectedCategory');
    }
}
