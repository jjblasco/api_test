<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParentesisTest extends TestCase
{
    private function url_with_token($url = null)
    {
        $token = '[]{}()';
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/check-order', [
            'order' => $url,
        ]);
    }

    public function test_parentesis_route_exists(): void
    {
        $response = $this->url_with_token();

        $response->assertStatus(200);
    }

    public function test_valid_order(): void
    {
        $response = $this->url_with_token('(){}[]');

        $response->assertStatus(200);
    }

    public function test_invalid_order(): void
    {
        $response = $this->url_with_token('({)}');

        $response->assertStatus(400);
    }
}
