<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void{
        parent::setUp();
        $this->password = 'password';
        $this->user = factory(User::class)->create([
            'password' => bcrypt($this->password),
        ]);
    }

    public function test_visible_show_login(){
        $response = $this->get('/login');
        $this->assertGuest();
        $response->assertStatus(200);
        $response->assertViewIs(('auth.login'));
    }

    public function test_member_cant_see_show_login(){
        $response = $this->actingAs($this->user)->get('/login');

        $response->assertRedirect('/');
    }

    public function test_can_login_with_correct_credentials(){
        $response = $this->from('/login')->post('/login', [
            'email'     => $this->user->email,
            'password'  => $this->password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_cant_login_with_incorrect_email(){
        $response = $this->from('/login')->post('/login',[
            'email'     => 'incorrect password',
            'password'  =>  $this->password,
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_cant_login_with_incorrect_password(){
        $response = $this->from('/login')->post('/login', [
            'email'     => $this->user->email,
            'password'  => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_rememberme(){

        $response = $this->post('/login', [
            'email'     => $this->user->email,
            'password'  => $this->password,
            'remember'  => 'on',
        ]);

        $response->assertRedirect('/');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $this->user->id,
            $this->user->getRememberToken(),
            $this->user->password,
        ]));
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_resist_guest_from_logout_get(){
        $response = $this->get('/logout');

        $this->assertGuest();
        $response->assertStatus(405);
    }

    public function test_resist_member_from_logout_get(){
        $response = $this->actingAs($this->user)->get('/logout');

        $this->assertAuthenticatedAs($this->user);
        $response->assertStatus(405);
    }

    public function test_accept_member_from_logout_post(){
        $this->actingAs($this->user)->assertAuthenticated();
        $response = $this->actingAs($this->user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
