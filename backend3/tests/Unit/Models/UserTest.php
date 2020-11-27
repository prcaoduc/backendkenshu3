<?php

namespace Tests\Feature\Models;

use App\Article;
use App\Image;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void{
        parent::setUp();

        $this->user     = factory(User::class)->create();
        $this->article  = factory(Article::class)->create([
            'author_id' => $this->user->id,
        ]);
        $this->image    = factory(Image::class)->create([
            'user_id'   => $this->user->id,
        ]);

    }

    public function test_user_has_many_articles(){
        $this->user->articles()->save($this->article);
        $this->assertInstanceOf(HasMany::class, $this->user->articles());
        $this->assertEquals('author_id', $this->user->articles()->getForeignKeyName());
        $this->assertDatabaseHas('articles', [
            'id'            => $this->article->id,
            'author_id'     => $this->user->id,
        ]);
    }

    public function test_user_has_many_images(){
        $this->user->images()->save($this->image);
        $this->assertInstanceOf(HasMany::class, $this->user->images());
        $this->assertEquals('user_id', $this->user->images()->getForeignKeyName());
        $this->assertDatabaseHas('images', [
            'id'            => $this->image->id,
            'user_id'       => $this->user->id,
        ]);
    }
}