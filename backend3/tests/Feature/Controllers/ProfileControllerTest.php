<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_visible_profile()
    {
        $user     = factory(User::class)->create();
        $response       = $this->actingAs($user)->get(route('account.show'));

        $response->assertStatus(200)
                 ->assertViewIs('account.show');
    }
}
