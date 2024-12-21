<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class urlApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_short_urls_ruote_exists(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(200);
    }

    public function test_valid_url(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(200);
    }

    public function test_when_url_is_not_string(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 123,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('url');
        $response->assertJsonFragment([
            'url' => ['la URL debe ser un texto'],
        ]);
    }

    public function test_when_url_is_void(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => '',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('url');
        $response->assertJsonFragment([
            'url' => ['la URL es requerida'],
        ]);
    }

    public function test_response_from_tinyurl(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'url',
        ]);

    }
}
