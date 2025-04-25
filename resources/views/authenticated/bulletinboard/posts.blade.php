<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto"></p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="subtitle"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
        @foreach($post->subCategories as $subCategory)
          <span class="subcategoryTitle">{{ $subCategory->sub_category }}</span>
        @endforeach
      <div class="post_bottom_area d-flex">
          <!-- リレーションの配列の時はforeachの中でリレーションをして中はそのまま記述 -->
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="comment_counts{{$post->id}}">{{$post->postComments->count() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->where('like_post_id', $post->id)->count() }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->where('like_post_id', $post->id)->count() }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class="btn-lightBlue"><a class="postBtn" href="{{ route('post.input') }}" >投稿</a></div>
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="キーワードを検索" name="keyword" form="postSearchRequest"><button type="submit" class="input-group-text" id="basic-addon2" form="postSearchRequest">検索</button>
      </div>
    </div>
      <input type="submit" name="like_posts" class="category_btn btn-pink" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn btn-yellow" value="自分の投稿" form="postSearchRequest">

      <div class="accordion-container">
        @foreach($categories as $category)
        <div class="accordion-item">
          <span class="mainCategory">{{ $category->main_category }}</span>
          <button class="accordion-button" data-category-category_id="{{ $category->id }}"></button>
        <div class="accordion-content">
          @foreach($category->subCategories as $subCategory)
            <span name="sub_category" class="sub clickable-sub" data-keyword="{{ $subCategory->sub_category }}">{{ $subCategory->sub_category }}</span>
          @endforeach
          </div>
        </div>
        @endforeach
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"><input type="hidden" name="sub_category" id="keywordField"></form>
</div>
</x-sidebar>
