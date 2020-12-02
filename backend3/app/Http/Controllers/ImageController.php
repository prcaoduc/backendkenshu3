<?php

namespace App\Http\Controllers;

use App\Facades\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function store(StoreImageRequest $request)
    {
        DB::transaction(function () use ($request) {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $url = ImageService::storeAjaxRequest($file);
                    $image = Image::create([
                        'user_id' => Auth::id(),
                        'url' => $url,
                    ]);
                    if (!$image) {
                        throw new \Exception('イメージ情報の保存が失敗した！');
                    }
                }
            }
        }, 5);

        return response()->json(['success' => 'Success !']);
    }

}
