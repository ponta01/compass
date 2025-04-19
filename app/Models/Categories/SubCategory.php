<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Post;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];

    // メインカテゴリーとサブカテゴリーの1対多のリレーション
    public function mainCategory(){
        return $this->belongsTo(MainCategory::class, 'main_category_id');// リレーションの定義
    }

    // サブカテゴリーとポストサブカテゴリーの多対多リレーション
    public function posts(){
        return $this->belongsToMany(Post::class, 'post_sub_categories', 'sub_category_id', 'post_id');
}

}
