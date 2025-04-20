<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    // public function likeCounts($post_id){
    //     return $this->where('like_post_id', $post_id)->get()->count();
    // }

    public function likeCounts($post_id)
{
    $post = Post::with('likes')->find($post_id); // Eagerly load the likes relationship
    return $post ? $post->likes->count() : 0; // Return the count if the post exists, otherwise return 0
}

}
