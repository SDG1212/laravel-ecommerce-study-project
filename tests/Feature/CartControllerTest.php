<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    public function test_get_cart_info_method_exists()
    {
        $response = $this->getJson('cart/info');

        $response->assertStatus(200);
    }

    public function test_add_product_to_cart_method_exists()
    {
        $response = $this->postJson('cart/add', [
            'id' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_add_product_cart_validation()
    {
        $response = $this->postJson('cart/add', []);

        $response->assertStatus(422);

        $response = $this->postJson('cart/add', [
            'id' => '',
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('cart/add', [
            'id' => 0,
        ]);

        $response->assertStatus(422);
    }

    public function test_edit_product_in_cart_method_exists()
    {
        $response = $this->postJson('cart/edit', [
            'id' => 1,
            'quantity' => 2
        ]);

        $response->assertStatus(200);
    }

    public function test_edit_product_cart_validation()
    {
        $response = $this->postJson('cart/edit', []);

        $response->assertStatus(422);

        $response = $this->postJson('cart/edit', []);

        $response->assertStatus(422);

        $response = $this->postJson('cart/edit', [
            'id' => '',
            'quantity' => '',
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('cart/edit', [
            'id' => 0,
            'quantity' => 0,
        ]);

        $response->assertStatus(422);
    }

    public function test_delete_product_from_cart_method_exists()
    {
        $response = $this->postJson('cart/delete', [
            'id' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_product_cart_validation()
    {
        $response = $this->postJson('cart/delete', []);

        $response->assertStatus(422);

        $response = $this->postJson('cart/delete', [
            'id' => '',
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('cart/delete', [
            'id' => 0,
        ]);

        $response->assertStatus(422);
    }
}
