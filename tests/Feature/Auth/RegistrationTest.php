<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $roles = auth()->user()->roles->toArray();
        if (count($roles) == 1 && $roles[0]['name'] === "user") {
            $redirect = RouteServiceProvider::CLIENT_HOME;
        } else {
            $redirect = RouteServiceProvider::ADMIN_HOME;
        }
        $response->assertRedirect($redirect);
    }
}
