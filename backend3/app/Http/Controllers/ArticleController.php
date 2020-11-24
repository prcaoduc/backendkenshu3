<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $article    = Article::with(['images', 'tags'])->findOrFail($id);
        $images     = $article->images()->get();
        $tags       = $article->tags()->get();
        return view('articles.show', compact('article', 'images', 'tags'));
    }
}
