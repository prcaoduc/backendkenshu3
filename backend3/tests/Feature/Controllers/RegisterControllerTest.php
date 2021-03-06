<?php

namespace Tests\Feature\Controller;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_guest_visible_show_register()
    {
        $response = $this->get('/register');
        $this->assertGuest();
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_member_cant_see_show_register()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/register');
        $response->assertRedirect('/');
    }

    public function test_can_signup_validated_data()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Gil-galad',
            'email' => 'gil-galad@lindon.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }
}
