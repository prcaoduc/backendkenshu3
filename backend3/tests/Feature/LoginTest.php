<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_visible_show_login(){
        $response = $this->get('/login');
        $this->assertGuest();
        $response->assertStatus(200);
        $response->assertViewIs(('auth.login'));
    }

    public function test_member_cant_see_show_login(){
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    public function test_can_login_with_correct_credentials(){
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->post('/login', [
            'email'     => $user->email,
            'password'  => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_cant_login_with_incorrect_email(){
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->from('/login')->post('/login',[
            'email'     => 'incorrect password',
            'password'  =>  $password,
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_cant_login_with_incorrect_password(){
        $user = factory(User::class)->create([
            'password'  => bcrypt('pasword'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email'     => $user->email,
            'password'  => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_rememberme(){
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->post('/login', [
            'email'     => $user->email,
            'password'  => $password,
            'remember'  => 'on',
        ]);

        $response->assertRedirect('/');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }
}
