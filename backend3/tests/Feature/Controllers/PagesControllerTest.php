<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void{
        parent::setUp();
    }

    public function test_visible_homepage(){
        $response = $this->get(route('home'));
        $response->assertStatus(200)
                 ->assertViewIs('pages.home');
    }
}
