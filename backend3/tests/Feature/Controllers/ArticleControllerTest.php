<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Article;
use App\User;
use App\Tag;
use App\Image;
use App\Role;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp() : void{
        parent::setUp();
        //　仮定データを準備する
        $this->user     = factory(User::class)->create();
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
        $this->journalist_role = Role::create([
            'name' => 'Journalist',
            'slug' => 'journalist',
            'permissions' => [
                'article.create'    => true,
            ]
        ]);
        $this->customer_role = Role::create([
            'name' => 'Customer',
            'slug' => 'customer',
            'permissions' => [
            ]
        ]);
        $this->article  = factory(Article::class)->create(['author_id' => $this->user->id]);
        $this->tags     = factory(Tag::class, 2)->create();
        $this->images    = factory(Image::class, 3)->create();
    }

    public function test_visible_article(){
        $response = $this->get(route('articles.show', ['id' => $this->article->id]));
        $response->assertStatus(200)
                 ->assertViewIs('articles.show');
    }

    public function test_editor_visible_create_article(){
        $response = $this->actingAs($this->user)->get('/articles/create');
        dd($this->journalist_role = Role::where('slug', 'journalist')->first());
        $response->assertStatus(200)
                 ->assertViewIs('articles.create');
    }

    public function test_guest_invisible_create_article(){
        $response = $this->get('/articles/create');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_store_article(){
        $this->actingAs($this->user)->assertAuthenticated();
        $response = $this->actingAs($this->user)->from('/articles/create')->post('/articles/create',[
            'title'             => 'abcabcabc',
            'content'           => 'abcabcabc',
            'tag'               => ['abcabcabc'],
        ]);
        $response->assertRedirect('me/'.$this->user->id);
    }

    public function test_store_article_with_image(){
        $this->actingAs($this->user)->assertAuthenticated();
        $response = $this->actingAs($this->user)->from('/articles/create')->post('/articles/create',[
            'title'             => 'abcabcabc',
            'content'           => 'abcabcabc',
            'tag'               => ['abcabcabc', 'saiudyasiuy'],
            'selected_images'   => $this->images->pluck('id'),
            'thumbnail'         => '2',
        ]);
        $response->assertRedirect('me/'.$this->user->id);
    }

    public function test_store_article_without_selected_thumbnail(){
        $this->actingAs($this->user)->assertAuthenticated();
        $response = $this->actingAs($this->user)->from('/articles/create')->post('/articles/create',[
            'title'             => 'abcabcabc',
            'content'           => 'abcabcabc',
            'tag'               => ['abcbacbac', 'xyzxyzxyz'],
            'selected_images'   => $this->images->pluck('id'),
        ]);
        $response->assertRedirect('me/'.$this->user->id);
    }

    public function test_visible_edit_article(){
        $this->actingAs($this->user)->assertAuthenticated();
        $response = $this->actingAs($this->user)->get('/articles/'.$this->article->id.'/edit');
        $response->assertStatus(200)
                 ->assertViewIs('articles.edit');
    }

    public function test_guest_invisible_edit_article(){
        $response = $this->get('/articles/'.$this->article->id.'/edit');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_update_article(){
        $this->actingAs($this->user)->assertAuthenticated();
        $response = $this->actingAs($this->user)->from('/articles/'.$this->article->id.'/edit')->post('/articles/'.$this->article->id.'/update',[
            'title'     => 'abcabcabc',
            'content'   => 'abcabcabc',
            'tag'       => ['abcbacbac', 'xyzxyzxyz'],
        ]);
        $response->assertRedirect('me/'.$this->user->id);
    }

    public function test_delete_article(){
        $this->actingAs($this->user)->assertAuthenticated();
        $response = $this->actingAs($this->user)->post('/articles/'.$this->article->id.'/delete');

    }
}
