<?php

use App\Models\product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list products', function () {
    $products = Product::factory()->count(5)->create();

    $response = $this->getJson('/api/v1/products');

    $response->assertStatus(200);
});

it('can create a product', function () {
    $productData = Product::factory()->make()->toArray();

    $response = $this->postJson('/api/v1/products', $productData);

    $response->assertStatus(201);
    $response->assertJsonFragment($productData);
});

it('can show a product', function () {
    $product = Product::factory()->create();

    $response = $this->getJson("/api/v1/products/{$product->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment($product->toJson());
});

it('can update a product', function () {
    $product = Product::factory()->create();
    $newData = ['name' => 'Mudou o nome'];

    $response = $this->putJson("/api/v1/products/{$product->id}", $newData);

    $response->assertStatus(200);
    $response->assertJsonFragment($newData);
});

it('can delete a product', function () {
    $product = Product::factory()->create();

    $response = $this->deleteJson("/api/v1/products/{$product->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

