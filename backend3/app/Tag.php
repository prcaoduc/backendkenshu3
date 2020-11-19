<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
