<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ThumbnailStatus;

class Article extends Model
{
    protected $fillable = [
        'title', 'content'
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function images(){
        return $this->belongsToMany('App\Image')->withPivot('isThumbnail');
    }

    public function thumbnail(){
        return $this->images()->wherePivot('isThumbnail', ThumbnailStatus::isThumbnail);
    }
}
