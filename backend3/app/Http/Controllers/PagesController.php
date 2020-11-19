<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Article;

class PagesController extends Controller
{
    public function home(){
        return view('pages.home', ['articles' => Article::with('tags')->get()]);
    }
}
