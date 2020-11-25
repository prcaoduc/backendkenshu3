<?php

namespace App;

use App\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ThumbnailStatus;

class Article extends Model
{
    protected $fillable = [
        'title', 'content', 'author_id', 'activeStatus',
    ];

    public function author(){
        return $this->belongsTo('App\User');
    }

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

    public function scopePublished($query){
        return $query->where('activeStatus', '=', ArticleStatus::Published);
    }
}
