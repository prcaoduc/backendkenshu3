<?php

namespace Tests\Feature\Policies;

use App\Article;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUp();
        //　仮定データを準備する
        $this->editor = factory(User::class)->create();
        $this->journalist = factory(User::class)->create();
        $this->customer = factory(User::class)->create();
        $this->editor_role = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => [
                'article.publish' => true,
                'article.update' => true,
                'article.create' => true,
                'article.delete' => true,
                'article.destroy' => true,
            ],
        ]);
        $this->editor->roles()->attach([$this->editor_role->id]);

        $this->journalist_role = Role::create([
            'name' => 'Journalist',
            'slug' => 'journalist',
            'permissions' => [
                'article.create' => true,
            ],
        ]);
        $this->journalist->roles()->attach([$this->journalist_role->id]);

        $this->customer_role = Role::create([
            'name' => 'Customer',
            'slug' => 'customer',
            'permissions' => [
            ],
        ]);
        $this->customer->roles()->attach([$this->customer_role->id]);
        $this->article = factory(Article::class)->create(['author_id' => $this->journalist->id]);
        $this->editor_article = factory(Article::class)->create(['author_id' => $this->editor->id]);
    }

    public function test_editor_visible_create_article()
    {
        $response = $this->actingAs($this->editor)->get('/articles/create');
        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }

    public function test_journalist_visible_create_article()
    {
        $response = $this->actingAs($this->journalist)->get('/articles/create');
        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }

    public function test_customer_invisible_create_article()
    {
        $response = $this->actingAs($this->customer)->get('/articles/create');
        $response->assertStatus(403);
    }

    public function test_store_article()
    {
        $this->actingAs($this->journalist)->assertAuthenticated();
        $response = $this->actingAs($this->journalist)->from('/articles/create')->post('/articles/create', [
            'title' => 'abcabcabc',
            'content' => 'abcabcabc',
            'tag' => ['abcabcabc'],
        ]);
        $response->assertRedirect('me/');
    }

    public function test_editor_visible_edit_article()
    {
        $this->actingAs($this->editor)->assertAuthenticated();
        $response = $this->actingAs($this->editor)->get('/articles/' . $this->editor_article->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('articles.edit');
    }

    public function test_editor_visible_edit_all_article()
    {
        $this->actingAs($this->editor)->assertAuthenticated();
        $response = $this->actingAs($this->editor)->get('/articles/' . $this->article->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('articles.edit');
    }

    public function test_journalist_visible_edit_article()
    {
        $this->actingAs($this->journalist)->assertAuthenticated();
        $response = $this->actingAs($this->journalist)->get('/articles/' . $this->article->id . '/edit');
        $response->assertStatus(200)
            ->assertViewIs('articles.edit');
    }

    public function test_journalist_invisible_another_people_edit_article()
    {
        $this->actingAs($this->journalist)->assertAuthenticated();
        $response = $this->actingAs($this->journalist)->get('/articles/' . $this->editor_article->id . '/edit');
        $response->assertStatus(403);
    }

    public function test_customer_invisible_edit_article()
    {
        $this->actingAs($this->customer)->assertAuthenticated();
        $response = $this->actingAs($this->customer)->get('/articles/' . $this->article->id . '/edit');
        $response->assertStatus(403);
    }

    public function test_editor_own_update_article()
    {
        $this->actingAs($this->editor)->assertAuthenticated();
        $response = $this->actingAs($this->editor)->from('/articles/' . $this->editor_article->id . '/edit')->post('/articles/' . $this->editor_article->id . '/update', [
            'title' => 'abcabcabc',
            'content' => 'abcabcabc',
            'tag' => ['abcbacbac', 'xyzxyzxyz'],
        ]);
        $response->assertRedirect('me/drafts');
    }

    public function test_editor_update_all_article()
    {
        $this->actingAs($this->editor)->assertAuthenticated();
        $response = $this->actingAs($this->editor)->from('/articles/' . $this->article->id . '/edit')->post('/articles/' . $this->article->id . '/update', [
            'title' => 'abcabcabc',
            'content' => 'abcabcabc',
            'tag' => ['abcbacbac', 'xyzxyzxyz'],
        ]);
        $response->assertRedirect('me/drafts');
    }

    public function test_journalist_own_update_article()
    {
        $this->actingAs($this->journalist)->assertAuthenticated();
        $response = $this->actingAs($this->journalist)->from('/articles/' . $this->article->id . '/edit')->post('/articles/' . $this->article->id . '/update', [
            'title' => 'abcabcabc',
            'content' => 'abcabcabc',
            'tag' => ['abcbacbac', 'xyzxyzxyz'],
        ]);
        $response->assertRedirect('me/drafts');
    }

    public function test_journalist_cant_update_another_people_article()
    {
        $this->actingAs($this->journalist)->assertAuthenticated();
        $response = $this->actingAs($this->journalist)->from('/articles/' . $this->editor_article->id . '/edit')->post('/articles/' . $this->editor_article->id . '/update', [
            'title' => 'abcabcabc',
            'content' => 'abcabcabc',
            'tag' => ['abcbacbac', 'xyzxyzxyz'],
        ]);
        $response->assertStatus(403);
    }

    public function test_journalist_delete_own_article()
    {
        $this->actingAs($this->journalist)->assertAuthenticated();
        $response = $this->actingAs($this->journalist)->post('/articles/' . $this->article->id . '/delete');
        $response->assertRedirect('me/');
    }

    public function test_journalist_cant_delete_another_people_article()
    {
        $this->actingAs($this->journalist)->assertAuthenticated();
        $response = $this->actingAs($this->journalist)->post('/articles/' . $this->editor_article->id . '/delete');
        $response->assertStatus(403);
    }

    public function test_editor_cant_delete_all_article()
    {
        $this->actingAs($this->editor)->assertAuthenticated();
        $response = $this->actingAs($this->editor)->post('/articles/' . $this->article->id . '/delete');
        $response->assertRedirect('me/');
    }
}
