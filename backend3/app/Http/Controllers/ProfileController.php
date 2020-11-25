<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($id){
        $user       = Auth::user()->load('articles');
        $articles   = $user->articles()->published()->get();
        return view('profile.show', compact('user', 'articles'));
    }
}
