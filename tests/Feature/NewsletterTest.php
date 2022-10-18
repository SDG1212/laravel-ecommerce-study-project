<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка работы подписки на рассылку.
     *
     * @return void
     */
    public function test_subscribe_validation()
    {
        // If E-mail is empty
        $response = $this->postJson('/subscribe', [
            'email' => ''
        ]);

        $response->assertStatus(422);

        // If E-mail isn't correct
        $response = $this->postJson('/subscribe', [
            'email' => 'test.example.com'
        ]);

        $response->assertStatus(422);

        // If E-mail is dublicated
        $response = $this->postJson('/subscribe', [
            'email' => 'test.example.com'
        ]);

        $response = $this->postJson('/subscribe', [
            'email' => 'test.example.com'
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('/subscribe', [
            'email' => 'test@example'
        ]);

        $response->assertStatus(200);

        $response = $this->postJson('/subscribe', [
            'email' => 'test@exampe.com'
        ]);

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
            $json->hasAny('newsletter_id')
        );
    }
}
