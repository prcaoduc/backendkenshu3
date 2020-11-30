<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AccountController extends Controller
{
    public function show(){
        $user       = Auth::user()->load('articles');
        $articles   = $user->articles()->published()->get();
        return view('account.show', compact('user', 'articles'));
    }

    public function drafts(){
        $user = Auth::user();
        $articlesQuery   = Article::unpublished();
        if(Gate::denies('article.draft')){
            $articlesQuery = $articlesQuery->where('author_id', $user->id);
        }
        $articles   = $articlesQuery->get();
        return view('account.drafts', compact('user', 'articles'));
    }
}
