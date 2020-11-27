<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['user_id', 'url'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function articles(){
        return $this->belongsToMany('App\Article');
    }
}
