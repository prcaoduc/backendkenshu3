<?php

namespace Tests\Feature\Controllers;

use App\Article;
use App\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void{
        parent::setUp();
        //　仮定データを準備する
        $this->editor       = factory(User::class)->create();
        $this->journalist   = factory(User::class)->create();
        $this->customer     = factory(User::class)->create();
        $this->editor_role = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => [
                'article.publish'   => true,
                'article.update'    => true,
                'article.create'    => true,
                'article.delete'    => true,
                'article.destroy'   => true,
            ]
        ]);
        $this->editor->roles()->attach([$this->editor_role->id]);

        $this->journalist_role = Role::create([
            'name' => 'Journalist',
            'slug' => 'journalist',
            'permissions' => [
                'article.create'    => true,
            ]
        ]);
        $this->journalist->roles()->attach([$this->journalist_role->id]);

        $this->customer_role = Role::create([
            'name' => 'Customer',
            'slug' => 'customer',
            'permissions' => [
            ]
        ]);
        $this->customer->roles()->attach([$this->customer_role->id]);
        $this->article  = factory(Article::class)->create(['author_id' => $this->journalist->id]);
        $this->editor_article  = factory(Article::class)->create(['author_id' => $this->editor->id]);
    }

    public function test_visible_show()
    {
        $user       = factory(User::class)->create();
        $response   = $this->actingAs($user)->get(route('account.show'));

        $response->assertStatus(200)
                 ->assertViewIs('account.show');
    }

    public function test_guest_invisible_show()
    {
        $response   = $this->get(route('account.show'));
        $response->assertStatus(302)
                 ->assertRedirect('/login');
    }

    public function test_editor_visible_all_drafts(){
        $response   = $this->actingAs($this->editor)->get(route('account.drafts'));
        $response->assertStatus(200)
                 ->assertViewIs('account.drafts');
    }

}
