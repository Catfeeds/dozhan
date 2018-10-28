<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SoftDeletes;    //启用软删除

    protected $fillable = ['name','description','category_id','url','cover'];

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /*
     * 获取此作品的标签
     */
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    /*
     * 获取此作品的所属分类
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /*
     * 获取此作品的所有评论
     */
    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }

    /*
     * 获取此作品的所属用户
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /*
     * 获取此作品的所有点赞
     */
    public function favours(){
        return $this->morphMany(Favour::class,'favourable');
    }
}