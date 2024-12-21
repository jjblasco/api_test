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
        $response = $this->post('api/v1/short-urls');

        $response->assertStatus(200);
    }
}
