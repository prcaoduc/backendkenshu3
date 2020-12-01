<?php

namespace Tests\Feature\Models;

use App\Article;
use App\Image;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
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
        $this->journalist_role = Role::where('slug', 'journalist')->first();
        $this->editor_role = Role::where('slug', 'editor')->first();

    }

    public function test_user_has_many_articles()
    {
        $this->user->articles()->save($this->article);
        $this->assertInstanceOf(HasMany::class, $this->user->articles());
        $this->assertEquals('author_id', $this->user->articles()->getForeignKeyName());
        $this->assertDatabaseHas('articles', [
            'id' => $this->article->id,
            'author_id' => $this->user->id,
        ]);
    }

    public function test_user_has_many_images()
    {
        $this->user->images()->save($this->image);
        $this->assertInstanceOf(HasMany::class, $this->user->images());
        $this->assertEquals('user_id', $this->user->images()->getForeignKeyName());
        $this->assertDatabaseHas('images', [
            'id' => $this->image->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_belongs_to_many_roles()
    {
        $this->user->roles()->attach($this->journalist_role);
        $this->assertInstanceOf(BelongsToMany::class, $this->user->roles());
    }
}
