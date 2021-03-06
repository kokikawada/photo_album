<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'profile'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function albums(){
        return $this->hasMany('App\Album');
    }
    
    public function likes(){
        return $this->hasMany('App\Like');
    }
    
    public function likeAlbum(){
        return $this->belongsToMany('App\Album', 'likes');
    }
    
    public function follows(){
        return $this->hasMany('App\Follow');
    }
    
    public function follow_users(){
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follow_id');
    }
    
    public function followers(){
        return $this->belongsToMany('App\User', 'follows', 'follow_id', 'user_id');
    }
    
    public function isFollowBy($id){
        return $result = $this->follow_users->pluck('id')->contains($id);
    }
}
