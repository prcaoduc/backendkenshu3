<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Article;
use App\Http\Controllers\ArticleController;
use App\User;
use App\Tag;
use App\Image;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void{
        parent::setUp();
        $this->faker = new Faker();

        //　仮定データを準備する
        $this->users = factory(User::class)->create();
        $this->article = [
            'title'         => $this->faker->name,
            'content'       => $this->faker->realText,
            'created_at'    => $this->faker->dateTimeBetween('-10 years', 'now', null),
            'author_id'     => $this->users->id,
        ];
        $this->tags = factory(Tag::class, 2)->create()->get();
        $this->image = factory(Image::class)->create();

        // テストしたいのコントローラーを作成する
        $this->ArticleController = new ArticleController();
    }
}
