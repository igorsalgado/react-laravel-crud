<?php

use App\Models\product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\AuthHelper;


it('can list products', function () {
    AuthHelper::authenticate();

    $products = Product::factory()->create();

    $response = $this->getJson('/api/v1/products');

    $response->assertStatus(200);
});

it('can create a product', function () {

    AuthHelper::authenticate();

    $productData = Product::factory()->make()->toArray();

    $response = $this->postJson('/api/v1/products', $productData);

    $response->assertStatus(201);
    $response->assertJsonFragment($productData);
});

it('can show a product', function () {
    AuthHelper::authenticate();

    $product = Product::factory()->create();

    $response = $this->getJson("/api/v1/products/{$product->id}");

    $response->assertStatus(200);
});

it('can update a product', function () {
    AuthHelper::authenticate();

    $product = Product::factory()->create();
    $newData = ['name' => fake()->name()];

    $response = $this->putJson("/api/v1/products/{$product->id}", $newData);

    $response->assertStatus(200);
    $response->assertJsonFragment($newData);
});

it('can delete a product', function () {
    AuthHelper::authenticate();

    $product = Product::factory()->create();

    $response = $this->deleteJson("/api/v1/products/{$product->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

