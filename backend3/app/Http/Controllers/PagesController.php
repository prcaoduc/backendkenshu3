<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Article;

class PagesController extends Controller
{
    public function home(){
        $articles = Article::with('tags')->get();
        return view('pages.home', compact('articles'));
    }
}
