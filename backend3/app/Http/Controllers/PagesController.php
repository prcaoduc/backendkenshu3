<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function home()
    {
        $articles = Article::with('tags')->published()->get();

        return view('pages.home', compact('articles'));
    }
}
