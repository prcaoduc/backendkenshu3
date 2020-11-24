<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\ArticleStatus;

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

    public function create(){
        $user = Auth::user();
        $user_images = $user->images()->get();
        return view('articles.create', compact('user_images'));
    }

    public function store(Request $request){
        $request->validate([
            'title'     =>  'require',
            'content'   =>  'require',
            'tag'       =>  'require',
            'images'    =>  'mimes:jpeg,bmp,png,jpg|max:2048',
        ]);

        $article = new Article;
        $article->title         = $request->title;
        $article->content       = $request->content;
        $article->author_id     = Auth::id();
        $article->activeStatus  = ArticleStatus::Published
    }

    public function edit(){
        return view('articles.edit');
    }

    public function update(){}

    public function delete(){

    }
}
