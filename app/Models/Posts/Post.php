<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\SubCategory;


class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    // ユーザーモデルとポストモデルの1対多リレーション
    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    // postテーブルとpostCommentの1対多のリレーション
    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // サブカテゴリーとポストサブカテゴリーの多対多リレーション
    public function subCategories(){
        return $this->belongsToMany(SubCategory::class, 'post_sub_categories', 'post_id', 'sub_category_id');
}


    // コメント数
    // public function commentCounts($post_id){
    //     return Post::with('postComments')->find($post_id)->postComments();
    // }


    public function commentCounts($post_id){
    $post = Post::with('postComments')->find($post_id);
    return $post ? $post->postComments->count() : 0; // Return 0 if no post or comments exist
}

}
