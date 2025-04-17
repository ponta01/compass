<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
        'sub_category_id',
        'post_id',
    ];

    // ユーザーモデルとポストモデルの1対多リレーション
    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // サブカテゴリーとポストサブカテゴリーのリレーション
    public function subCategories(){
        return $this->belongsTo(SubCategory::class, 'sub_category_id');// リレーションの定義
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}
