<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_search_method_exists()
    {
        $response = $this->postJson('/search', [
            'text' => '',
        ]);

        $response->assertStatus(200);
    }
}
