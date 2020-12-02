<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    public function storeAjaxRequest(UploadedFile $file)
    {
        $ext = $file->guessExtension();
        $file_name = time() . '.' . $ext;
        $file->storeAs('/', $file_name, 'uploads');
        $url = asset('images/' . $file_name);

        return $url;
    }
}
