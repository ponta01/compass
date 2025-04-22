<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    public function showUsers(Request $request){
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = null;// ここで検索時の科目を受け取る
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        $subjects = Subjects::all();
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

        public function search(Request $request){
        // キーワードを取得
        $keyword = $request->input('keyword');
        dd($keyword);
        // 2つ目の処理
        if (empty($keyword)) {
        $results = User::all(); // または空のコレクションを返す
        } else {
        $results = User::where('last_name', 'LIKE', "%{$keyword}%")
                   ->orWhere('first_name', 'LIKE', "%{$keyword}%")
                   ->orWhere('last_name_kana', 'LIKE', "%{$keyword}%")
                   ->orWhere('first_name_kana', 'LIKE', "%{$keyword}%")
                   ->get();
        }
        // 3つ目の処理
        return view('authenticated.users.search',['keyword'=>$keyword, 'results'=>$results]);
    }


    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->syncWithoutDetaching($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}
