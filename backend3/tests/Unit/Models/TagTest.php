<?php

namespace Tests\Feature\Models;

use App\Article;
use App\Tag;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void{
        parent::setUp();
        $this->user     = factory(User::class)->create();
        $this->tag = factory(Tag::class)->create();
        $this->article = factory(Article::class)->create([
            'author_id'   => $this->user->id,
        ]);
    }

    public function test_tag_belongs_to_many_articles(){
        $this->tag->articles()->sync($this->article);
        $this->assertInstanceOf(BelongsToMany::class, $this->tag->articles());
        $this->assertEquals('tag_id', $this->tag->articles()->getForeignPivotKeyName());
        $this->assertEquals('article_id', $this->tag->articles()->getRelatedPivotKeyName());
        $this->assertDatabaseHas('article_tag', [
            'tag_id'        => $this->tag->id,
            'article_id'    => $this->article->id,
        ]);
    }
}
