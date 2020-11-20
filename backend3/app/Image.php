<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function user(){
        $this->belongsTo('App\User');
    }

    public function articles(){
        $this->belongsToMany('App\Article');
    }
}
