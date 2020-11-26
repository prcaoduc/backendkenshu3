<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'images'    => 'required',
            'images.*'  => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        // $arr = [];
        DB::transaction(function() use ($request) {
            if($request->hasFile('images')){
                foreach($request->file('images') as $file){
                    $ext = $file->guessExtension();
                    $file_name = time() . '.' .  $ext;
                    $file->storeAs('public/', $file_name);
                    $url = Storage::url($file_name);
                    // $url = Storage::disk('public')->get($file_name);
                    $image = Image::create([
                        'user_id'   => Auth::id(),
                        'url'       => $url,
                    ]);
                    if(!$image){
                        throw new \Exception('イメージ情報の保存が失敗した！');
                    }
                }
            }
        });
        return response()->json(['success'=> $request->all()]);
    }

}
