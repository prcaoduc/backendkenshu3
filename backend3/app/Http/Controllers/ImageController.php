<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'   => 'required',
            'images'    => 'required',
            'images.*'  => 'mimes:jpeg,bmp,png,jpg|max:2048',
        ]);
        $arr = [];
        DB::transaction(function() use ($request) {
            if($request->hasFile('images')){
                foreach($request->file('images') as $file){
                    $ext = $file->guessExtension();
                    $file_name = time() . '.' .  $ext;
                    $file_path = 'uploads/' . Auth::user()->name . '/' . $file_name;
                    $file->storeAs(('uploads/' . Auth::user()->name), $file_name);
                    array_push($arr, [$file_name, $file_path]);
                    $image = Image::create([
                        'user_id'   => $request->user_id,
                        'url'       => $file_path,
                    ]);
                    if(!$image){
                        throw new \Exception('イメージ情報の保存が失敗した！');
                    }
                }
            }
        });
        return $arr;
    }
}
