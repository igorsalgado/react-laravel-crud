<?php

namespace Tests\Helpers;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthHelper
{
    public static function authenticate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        return $user;
    }
}
