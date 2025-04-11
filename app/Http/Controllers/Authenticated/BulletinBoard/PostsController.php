<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request){

        $request->validate([
            'post_category_id' => ['required', 'string', 'exists:sub_categories,id'],
            'post_title' => ['required', 'string', 'max:100'],
            'post_body' => ['required', 'string', 'max:2000'],],[
		    'post_category_id.required' => 'カテゴリーは必ず入力してください。',
		    'post_category_id.exists:sub_categories,id' => '指定されたサブカテゴリーは登録されていません。',
		    'post_title.max' => 'タイトルは100文字以下です。',
		    'post_body.max' => '投稿内容は2000文字以下です。',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        return redirect()->route('post.show');
    }

    public function postEdit(Request $request){

        $request->validate([
            'post_title' => ['required', 'string', 'max:100'],
            'post_body' => ['required', 'string', 'max:2000'],],[
		    'post_title.max' => 'タイトルは100文字以下です。',
		    'post_body.max' => '投稿内容は2000文字以下です。',
        ]);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(Request $request){

        $request->validate([
            'main_category_name' => ['required', 'string', 'max:100','unique:categories,name'],
            'main_category_id' => ['required', 'string', 'max:2000','exists:main_categories,id'],
            'sub_category_name' => ['required', 'string', 'max:2000','unique:sub_categories,name'],],[
            'main_category_name.required' => 'メインカテゴリーは必ず入力してください。',
		    'post_title.max' => 'タイトルは100文字以下です。',
		    'main_category_name.unique' => '同じ名前のメインカテゴリーは登録できません。',
		    'main_category_id.exists:main_categories,id' => '指定されたメインカテゴリーは登録されていません。',
            'sub_category_name.required' => 'サブカテゴリーは必ず入力してください。',
		    'sub_category_name.unique' => '同じ名前のサブカテゴリーは登録できません。',
		    'post_body.max' => '投稿内容は2000文字以下です。',
            ]);

            MainCategory::create(['main_category' => $request->main_category_name]);
            return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){

        $request->validate([
            'comment' => ['required', 'string', 'max:250'],],[
		    'comment.max' => 'コメントは250文字以下です。',
        ]);

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
