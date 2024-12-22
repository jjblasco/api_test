<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class urlApiTest extends TestCase
{
    private function url_with_token($url)
    {
        $token = '[]{}()';
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/short-urls', [
            'url' => $url,
        ]);
    }

    public function test_short_urls_route_exists(): void
    {
        $response = $this->url_with_token('https://www.example.com');

        $response->assertStatus(200);
    }

    public function test_valid_url(): void
    {
        $response = $this->url_with_token('https://www.example.com');

        $response->assertStatus(200);
    }

    public function test_when_url_is_not_string(): void
    {
        $response = $this->url_with_token(1234);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('url');
        $response->assertJsonFragment([
            'url' => ["La URL debe tener un formato válido.","la URL debe ser un texto"],
        ]);
    }

    public function test_when_url_is_void(): void
    {
        $response = $this->url_with_token(null);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('url');
        $response->assertJsonFragment([
            'url' => ['la URL es requerida'],
        ]);
    }

    public function test_response_from_tinyurl(): void
    {
        $response = $this->url_with_token('https://www.example.com');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'url',
        ]);

    }

    public function test_invalid_token(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer no-token',
        ])->postJson('/api/v1/short-urls', [
            'url' => 'https://www.example.com',
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment([
            'error' => 'Token inválido o ausente.',
        ]);
    }

    public function test_missing_token(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment([
            'error' => 'Token inválido o ausente.',
        ]);
    }

}
