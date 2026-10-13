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
}
