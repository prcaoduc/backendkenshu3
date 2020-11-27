<?php

namespace Tests\Feature\Models;

use App\Article;
use App\Enums\ArticleStatus;
use App\Enums\ThumbnailStatus;
use App\Image;
use App\Tag;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void{
        parent::setUp();

        $this->user     = factory(User::class)->create();
        $this->article = factory(Article::class)->create([
            'author_id' => $this->user->id,
            ]);
        $this->image    = factory(Image::class)->create([
            'user_id'   => $this->user->id,
        ]);
        $this->tag      = factory(Tag::class)->create();
    }

    public function test_article_belongs_to_many_tags(){
        $this->article->tags()->sync($this->tag);
        $this->assertInstanceOf(BelongsToMany::class, $this->article->tags());
        $this->assertEquals('article_id', $this->article->tags()->getForeignPivotKeyName());
        $this->assertEquals('tag_id', $this->article->tags()->getRelatedPivotKeyName());
        $this->assertDatabaseHas('article_tag', [
            'article_id'    => $this->article->id,
            'tag_id'        => $this->tag->id,
        ]);
    }

    public function test_article_belongs_to_many_images(){
        $this->article->images()->sync($this->image);
        $this->assertInstanceOf(BelongsToMany::class, $this->article->images());
        $this->assertEquals('article_id', $this->article->images()->getForeignPivotKeyName());
        $this->assertEquals('image_id', $this->article->images()->getRelatedPivotKeyName());
        $this->assertDatabaseHas('article_image', [
            'article_id'    => $this->article->id,
            'image_id'      => $this->image->id,
        ]);
    }

    public function test_article_get_thumbnail(){
        $this->article->images()->sync($this->image->id, ['isThumbnail' => ThumbnailStatus::isThumbnail]);
        $thumbnail = $this->article->thumbnail[0];
        $this->assertDatabaseHas('article_image', [
            'article_id'        => $this->article->id,
            'image_id'          => $thumbnail->id,
            'isThumbnail'       => ThumbnailStatus::isThumbnail,
        ]);
    }

    public function test_article_get_published_scope(){
        $article = Mockery::mock(new Article);
        $this->assertInstanceOf(Builder::class, Article::published(ArticleStatus::Published));
    }
}
