<?php

namespace App;

use App\Enums\ArticleStatus;
use App\Enums\ThumbnailStatus;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'content', 'author_id', 'activeStatus',
    ];

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function images()
    {
        return $this->belongsToMany('App\Image')->withPivot('isThumbnail');
    }

    public function thumbnail()
    {
        return $this->images()->wherePivot('isThumbnail', ThumbnailStatus::isThumbnail);
    }

    public function scopePublished($query)
    {
        return $query->where('activeStatus', '=', ArticleStatus::Published);
    }

    public function scopeDraft($query)
    {
        return $query->where('activeStatus', '=', ArticleStatus::Draft);
    }

    public function scopeUnpublished($query)
    {
        return $query->where('activeStatus', '!=', ArticleStatus::Published);
    }
}
