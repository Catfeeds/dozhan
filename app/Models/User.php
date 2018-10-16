<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    //可写入字段
    protected $fillable = [
        'do_id','name','avatar','email','phone_number','qq_number','password',
    ];

    //隐藏字段
    protected $hidden = [
        'password', 'remember_token',
    ];

    //返回了 User 的 id
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    //需要额外再 JWT 载荷中增加的自定义内容
    public function getJWTCustomClaims()
    {
        return [];
    }

    //模型关联
    public function album(){
        return $this->hasMany(Album::class);
    }

    //模型关联
    public function av(){
        return $this->hasMany(Av::class);
    }

    //模型关联
    public function image(){
        return $this->hasMany(Image::class);
    }

    //模型关联
    public function video(){
        return $this->hasMany(Video::class);
    }

    //模型关联
    public function comment(){
        return $this->hasMany(Comment::class);
    }

}
