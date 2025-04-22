<x-sidebar>
<div class="search_content w-100 border d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person">
      <div>
        <form action="{{ route('user.show') }}" method="get" id="userSearchRequest">
        <span class="gray">ID : </span><span class="bold">{{ $user->id }}</span>
      </div>
      <div><span class="gray">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span class="bold">{{ $user->over_name }}</span>
          <span class="bold">{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span class="gray">カナ : </span>
        <span class="bold">({{ $user->over_name_kana }}</span>
        <span class="bold">{{ $user->under_name_kana }})</span>
      </div>
      </form>
      <div>
        @if($user->sex == 1)
        <span class="gray">性別 : </span><span class="bold">男</span>
        @elseif($user->sex == 2)
        <span class="gray">性別 : </span><span class="bold">女</span>
        @else
        <span class="gray"> 性別 : </span><span class="bold">その他</span>
        @endif
      </div>
      <div>
        <span class="gray">生年月日 : </span><span class="bold">{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span class="gray">権限 : </span><span class="bold">教師(国語)</span>
        @elseif($user->role == 2)
        <span class="gray">権限 : </span><span class="bold">教師(数学)</span>
        @elseif($user->role == 3)
        <span class="gray">権限 : </span><span class="bold">講師(英語)</span>
        @else
        <span class="gray">権限 : </span><span class="bold">生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
        <span class="gray">選択科目 :</span><span class="bold">国語</span>
        @elseif($user->$subjects == 2)
        <span class="gray">選択科目 :</span><span class="bold">数学</span>
        @else
        <span class="gray">選択科目 :</span><span class="bold">英語</span>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25 border">
    <div class="">
      <div>
        <p class="search">検索</p>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <label class="custom">カテゴリ</label>
        <select form="userSearchRequest" name="category" class="category-label">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div>
        <label class="custom">並び替え</label>
        <select name="updown" form="userSearchRequest" class="category-label">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="accordion_button">
        <p class="m-0 search_conditions"><span class="search-add accordion_arrow">検索条件の追加</span></p>
        <div class="search_conditions_inner">
          <div class="selected_engineer">
            <label class="content">性別</label>
            <br>
            <div class="sex-margin">
            <span class="man">男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
            </div>
          </div>
          <div class="selected_engineer">
            <label class="content">権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label class="content">選択科目</label>
            <div class="subject-margin">
            <span class="math">国語</span><input type="checkbox" name="subject" value="1" form="userSearchRequest">
            <span class="math">数学</span><input type="checkbox" name="subject" value="2" form="userSearchRequest">
            <span class="math">英語</span><input type="checkbox" name="subject" value="3" form="userSearchRequest">
            </div>
          </div>
        </div>
      </div>
      <div>
      </div>
      <div>
        <input type="submit" class="searchBtn" name="search_btn" value="検索" form="userSearchRequest">
        <input type="reset" class="reset" value="リセット" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
</x-sidebar>
