<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function images(){
        return $this->hasMany('App\Image');
    }

    public function articles(){
        return $this->hasMany('App\Article', 'author_id');
    }

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    /**
     * ユーザーが $permission をアクセスできるかどうか
     */
    public function hasAccess(array $permission){
        foreach($this->roles as $role){
            if($role->hasAccess($permission)) return true;
        }
        return false;
    }

    /**
     * ユーザーがこのロールのメンバーかを確認する
     */
    public function inRole($slug){
        return $this->roles()->where('slug', $slug)->count() == 1;
    }
}
