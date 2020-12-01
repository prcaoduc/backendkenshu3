<?php

namespace Tests\Feature\Models;

use App\Article;
use App\Image;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->article = factory(Article::class)->create([
            'author_id' => $this->user->id,
        ]);
        $this->image = factory(Image::class)->create([
            'user_id' => $this->user->id,
        ]);
        // dd($this->image);
    }

    public function test_image_belongs_to_user()
    {
        $this->image->user()->associate($this->user);
        $this->assertInstanceOf(BelongsTo::class, $this->image->user());
        $this->assertEquals('user_id', $this->user->images()->getForeignKeyName());
        $this->assertDatabaseHas('images', [
            'id' => $this->image->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_image_belongs_to_many_articles()
    {
        $this->image->articles()->sync($this->article);
        $this->assertDatabaseHas('article_image', [
            'image_id' => $this->image->id,
            'article_id' => $this->user->id,
        ]);
        $this->assertInstanceOf(BelongsToMany::class, $this->image->articles());
        $this->assertEquals('image_id', $this->image->articles()->getForeignPivotKeyName());
        $this->assertEquals('article_id', $this->image->articles()->getRelatedPivotKeyName());
    }
}
