<x-sidebar>
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      @if($errors->first('post_category_id'))
      <span class="error_message">{{ $errors->first('post_category_id') }}</span>
      @endif
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
        <optgroup class="main-category" label="{{ $main_category->main_category }}">
          <!-- サブカテゴリー表示 -->
          @foreach($main_category->subCategories as $sub_category)
            <option class="sub-category" value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
          @endforeach
        </optgroup>
        @endforeach
      </select>
    </div>

    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>

      <!-- ログインユーザーが講師だったら、下記のサブカテゴリーを表示させてね。みたいなif文をここら辺にいれるはず -->
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <div class="category">
        @if($errors->first('main_category_name'))
        <span class="error_message">{{ $errors->first('main_category_name') }}</span>
        @endif
        <form id="mainCategoryRequest" method="POST" action="{{ route('addMainCategory') }}">
          @csrf
          <p class="m-0">メインカテゴリー</p>
            <input type="text" class="w-100 margin" name="main_category_name">
            <input type="submit" value="追加" class="w-100 btn btn-primary p-0">
        </form>


      <!-- サブカテゴリー追加 -->
    @if($errors->first('sub_category_name'))
      <span class="error_message">{{ $errors->first('sub_category_name') }}</span>
    @endif
    <form id="mainCategoryRequest" method="POST" action="{{ route('getSubCategory') }}">
          @csrf
      <p class="mb-0">サブカテゴリー</p>
        <select class="w-100 margin" id="mainCategory" name="main_category_id">
          @foreach($main_categories as $main_category)
            <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
          @endforeach
        </select>
        <p class="m-0"></p>
          <input type="text" class="w-100 margin" name="sub_category_name">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0">
      </form>
    </div>
  </div>
  @endcan
</div>
</x-sidebar>
