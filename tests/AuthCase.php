<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

abstract class AuthCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard'); // Adjust the expected redirect URL
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user); // Log in the user
        $response = $this->post('/logout');

        $response->assertRedirect('/'); // Adjust the expected redirect URL
        $this->assertGuest();
    }
}
