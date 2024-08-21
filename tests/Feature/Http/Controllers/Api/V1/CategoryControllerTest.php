<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('can list categories', function () {
    $categories = Category::factory()->count(5)->create();

    $response = $this->getJson('/api/v1/categories');

    $response->assertStatus(200);
    $response->assertJsonCount(5);
});

it('can create a category', function () {
    $categoryData = Category::factory()->make()->toArray();

    $response = $this->postJson('/api/v1/categories', $categoryData);

    $response->assertStatus(201);
    $response->assertJsonFragment($categoryData);
});

it('can show a category', function () {
    $category = Category::factory()->create();

    $response = $this->getJson("/api/v1/categories/{$category->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment($category->toArray());
});

it('can update a category', function () {
    $category = Category::factory()->create();
    $newData = ['name' => 'Mudou o nome'];

    $response = $this->putJson("/api/v1/categories/{$category->id}", $newData);

    $response->assertStatus(200);
    $response->assertJsonFragment($newData);
});

it('can delete a category', function () {
    $category = Category::factory()->create();

    $response = $this->deleteJson("/api/v1/categories/{$category->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

