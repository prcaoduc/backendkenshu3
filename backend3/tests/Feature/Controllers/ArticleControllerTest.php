<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Article;
use App\User;
use App\Tag;
use App\Image;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp() : void{
        parent::setUp();
        //　仮定データを準備する
        $this->user     = factory(User::class)->create();
        $this->article  = factory(Article::class)->create(['author_id' => $this->user->id]);
        $this->tags     = factory(Tag::class, 2)->create();
        $this->image    = factory(Image::class)->create();
    }

    public function test_visible_article(){
        $response = $this->get( route('articles.show', ['id' => $this->article->id] ) );
        $response->assertStatus(200)
                 ->assertViewIs('articles.show');
    }
}
