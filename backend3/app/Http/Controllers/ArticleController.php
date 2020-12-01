<?php

namespace App\Http\Controllers;

use App\Article;
use App\Enums\ArticleStatus;
use App\Enums\ThumbnailStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Show the account for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $article = Article::with(['images', 'tags'])->findOrFail($id);
        $images = $article->images()->get();
        $tags = $article->tags()->get();

        return view('articles.show', compact('article', 'images', 'tags'));
    }

    public function create()
    {
        $user = Auth::user();
        $user_images = $user->images()->get();

        return view('articles.create', compact('user_images'));
    }

    public function store(StoreArticleRequest $request)
    {
        DB::transaction(function () use ($request) {
            $article = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'author_id' => Auth::id(),
                'activeStatus' => ArticleStatus::Published,
            ]);
            $tags = collect();
            foreach ($request->tag as $item) {
                $tags->push(Tag::firstOrCreate(['name' => $item]));
            }
            $article->tags()->attach($tags->pluck('id'));
            $selected_images = $request->selected_images;
            $thumbnail = $request->thumbnail;
            if (!$thumbnail) {
                $thumbnail = 0;
            }

            if ($selected_images && $thumbnail) {
                for ($i = 0; $i < count($selected_images); $i++) {
                    if ($thumbnail != 0) {
                        $thumbnail_status = ThumbnailStatus::isNotThumbnail;
                        if ($selected_images[$i] == $thumbnail) {
                            $thumbnail_status = ThumbnailStatus::isThumbnail;
                        }

                        $article->images()->attach($selected_images[$i], ['article_id' => $article->id, 'isThumbnail' => $thumbnail_status]);
                    } else if ($i == 0) {
                        $article->images()->attach($selected_images[$i], ['article_id' => $article->id, 'isThumbnail' => ThumbnailStatus::isThumbnail]);
                    } else {
                        $article->images()->attach($selected_images[$i], ['article_id' => $article->id, 'isThumbnail' => ThumbnailStatus::isNotThumbnail]);
                    }

                }
            }
        }, 5);

        return redirect(route('account.show'));
    }

    public function edit(Article $article)
    {
        $tags = $article->tags;

        return view('articles.edit', compact('article', 'tags'));
    }

    public function update(Article $article, UpdateArticleRequest $request)
    {
        DB::transaction(function () use ($request, $article) {
            $article->title = $request->title;
            $article->content = $request->content;
            $tags = collect();
            foreach ($request->tag as $item) {
                $tags->push(Tag::firstOrCreate(['name' => $item]));
            }
            $article->tags()->sync($tags->pluck('id'));
            $article->save();
        }, 5);

        return redirect(route('account.drafts'));
    }

    public function publish(Article $article)
    {
        $article->activeStatus = ArticleStatus::Published;
        $article->save();

        return redirect(route('account.drafts'));
    }

    public function delete(Article $article)
    {
        $article->activeStatus = ArticleStatus::Revoked;
        $article->save();

        return redirect(route('account.show'));
    }
}
