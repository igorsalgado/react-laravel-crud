<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\AuthHelper;


it('can list categories', function () {
    AuthHelper::authenticate();

    $response = $this->getJson('/api/v1/categories');

    $response->assertStatus(200);
});

it('can create a category', function () {
    AuthHelper::authenticate();

    $categoryData = Category::factory()->make()->toArray();

    $response = $this->postJson('/api/v1/categories', $categoryData);

    $response->assertStatus(201);
    $response->assertJsonFragment($categoryData);
});

it('can show a category', function () {
    AuthHelper::authenticate();

    $category = Category::factory()->create();

    $response = $this->getJson("/api/v1/categories/{$category->id}");

    $response->assertStatus(200);
});

it('can update a category', function () {
    AuthHelper::authenticate();

    $category = Category::factory()->create();
    $newData = ['name' => fake()->name()];

    $response = $this->putJson("/api/v1/categories/{$category->id}", $newData);

    $response->assertStatus(200);
    $response->assertJsonFragment($newData);
});

it('can delete a category', function () {
    AuthHelper::authenticate();

    $category = Category::factory()->create();

    $response = $this->deleteJson("/api/v1/categories/{$category->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

