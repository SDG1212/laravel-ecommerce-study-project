<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * @return void
     */
    public function test_home_page_is_rendered()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('home');
    }
}
