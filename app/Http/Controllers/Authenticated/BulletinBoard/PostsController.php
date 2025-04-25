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
use Illuminate\Support\Facades\DB; // DBファサードのインポート
use Auth;

class PostsController extends Controller
{

    public function search(Request $request){
        // キーワードを取得
        $subcategory = $request->input('keyword');

        if (empty($subcategory)) {
        // No keyword: retrieve all posts
        $results = Post::with('user', 'subCategories', 'postComments')->get();
        } else {
        // Filter posts associated with the given subcategory ID
        $results = SubCategory::whereHas('post_sub_categories', function ($q) use ($subcategory) {
            $q->where('post_sub_categories.sub_category', '=', $subcategory); // Filter by subcategory ID
        })
        ->with('user', 'subCategories', 'postComments') // Load related data
        ->get();
    }
        // 3つ目の処理
        return view('authenticated.bulletinboard.posts', [
        'keyword' => $subcategoryId,
        'posts' => $results
    ]);
}

    public function show(Request $request){
        $subcategory = $request->input('keyword');
        $posts = Post::with('user', 'postComments', 'subCategories')->get();
        $categories = MainCategory::with('subCategories')->get();
        $like = new Like;
        $post_comment = new Post;
        if (!empty($request->keyword)) {
    $posts = Post::with('user', 'postComments', 'subCategories')
        ->where('post_title', 'like', '%' . $request->keyword . '%')
        ->orWhere('post', 'like', '%' . $request->keyword . '%')
        ->orWhereHas('subCategories', function ($query) use ($request) {
            $query->where('sub_category', '=', $request->keyword);
        })->get();
        }else if ($request->sub_category) {
            // サブカテゴリで絞り込む処理
            $posts = Post::whereHas('subCategories', function ($query) use ($request) {
                $query->where('sub_category', $request->sub_category);
            })->get();
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
        $main_categories = MainCategory::with('subCategories')->get();
        // withはモデルのメインカテゴリーと一緒に今回はリレーションをした先のリレーション名のサブカテゴリーズの値を取得するという意味。
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

        $main_categories = MainCategory::with('subCategories')->get(); // リレーションを利用して取得

        DB::beginTransaction();
        try{

            $post = Post::create([
                'user_id' => Auth::id(),
                'post_title' => $request->post_title,
                'post' => $request->post_body,
            ]);

            $post_id = $post->id;
            $sub_category_id = $request->post_category_id;

            // 多対多のリレーションを利用して中間テーブルに登録
            $post->subCategories()->attach($sub_category_id);

            DB::commit();
            // ビューにデータを渡して表示
            return view('authenticated.bulletinboard.post_create', compact('main_categories'));
            } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('post.show')->with('error', $e->getMessage());
            }

    }

    public function postEdit(Request $request){

         Post::where('id', $request->post_id)->update([
             'post_title' => $request->post_title,
             'post' => $request->post_body,
         ]);

         $post = Post::where('user_id', Auth::id())->get(); // 自分の投稿のみ取得
         return redirect()->route('post.detail', ['id' => $request->post_id]);
     }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(Request $request){

        $request->validate([
            'main_category_id' => ['required', 'string', 'max:2000','exists:main_categories,id'],
            'sub_category_name' => ['required', 'string', 'max:2000','unique:sub_categories,name'],],[
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
		    'comment.required' => 'コメントは必ず入力してください。',
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
        $likes = Like::all(); // すべての「いいね」を取得
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'likes'));
}

     public function likeBulletinBoard(){
         $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
         $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
         $like = new Like;
         return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
     }

     public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;


        // $like = new Like;
        // すでにいいねが存在するか確認
        $existingLike = Like::where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->first();

        if (!$existingLike) {
            // まだいいねしていない場合、新しいいいねを作成
            $like = new Like;
            $like->like_user_id = $user_id;
            $like->like_post_id = $post_id;
            $like->save();
        } else {
            // すでにいいねしている場合、いいねを取り消す
            $existingLike->delete();
        }

        return response()->json();
    }

     public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }

    public function store(Request $request)
{
    $existingNames = MainCategory::pluck('main_category')->toArray();
    // バリデーション
    $request->validate([
    'main_category_name' => ['required', 'string', 'max:100', function ($attribute, $value, $fail) use ($existingNames) {
        if (in_array($value, $existingNames)) {
            $fail('このメインカテゴリー名はすでに登録されています。');
        }
    }]
], [
    'main_category_name.required' => 'メインカテゴリーは必ず入力してください。',
    'main_category_name.string' => 'メインカテゴリーは文字列でなければなりません。',
    'main_category_name.max:100' => 'メインカテゴリーは最大100文字を超えてはいけません。',
]);

    // 新しいメインカテゴリーをデータベースに保存
    $mainCategory = new MainCategory();
    $mainCategory->main_category = $request->input('main_category_name');
    $mainCategory->save();

    return redirect()->back()->with('success', 'メインカテゴリーが追加されました！');
}

    public function getSubCategories(Request $request)
{
    $existingNames = SubCategory::pluck('sub_category')->toArray();
    // バリデーション
    $request->validate([
    'sub_category_name' => ['required', 'string', 'max:100', function ($attribute, $value, $fail) use ($existingNames) {
        if (in_array($value, $existingNames)) {
            $fail('このサブカテゴリー名はすでに登録されています。');
        }
    }]
], [
    'sub_category_name.required' => 'サブカテゴリーは必ず入力してください。','sub_category_name.string' => 'サブカテゴリーは文字列でなければなりません。','sub_category_name.max:100' => 'サブカテゴリーは最大100文字を超えてはいけません。',
]);

    $subCategory = new SubCategory();
    // 空の入力欄を作ってね
    $subCategory->sub_category = $request->input('sub_category_name');
    // 紫はカラム名、inputタグで飛ばしてきたname属性のサブカテゴリー名をデータベースに登録。
    $subCategory->main_category_id = $request->input('main_category_id');
    // 今回はリレーションをした外部キーに該当するから、データベースのメインカテゴリーIDに手動でブレードのinputラグで飛ばしてきたname属性のメインカテゴリーidをデータベースに登録する。
    $subCategory->save();

    return redirect()->back()->with('success', 'サブカテゴリーが追加されました！');
}

   public function postValidates(PostRequest $request) {
        return view('auth.register.register',['msg'=>'OK']);
}

}
