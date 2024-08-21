<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\Helpers\AuthHelper;

it('can login ', function () {

    $user = User::factory()->create([
        'password' => bcrypt($password = 'password123'),
    ]);

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => $password,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['access_token']);
    $this->assertNotNull($response->json('access_token'));
});

it('can register', function () {

    $email = fake()->email();
    $data = [
        'name' => 'Igor',
        'email' => $email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->postJson('/api/v1/register', $data);

    $response->assertStatus(201);

    $response->assertJsonStructure([
        'access_token',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => $email,
    ]);

});

it('can logout', function () {

    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/v1/logout');

    $response->assertStatus(200);



});

