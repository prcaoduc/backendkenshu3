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
        return view('article.show', ['article' => Article::findOrFail($id)]);
    }
}
