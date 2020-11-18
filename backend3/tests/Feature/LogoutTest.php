<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void{
        parent::setUp();

        $this->user = factory(User::class)->create();
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
