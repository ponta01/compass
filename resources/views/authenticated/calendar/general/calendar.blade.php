<x-sidebar>
<div class="vh-90 pt-4" style="background:#ECF1F6;">
  <div class="border w-75 h-95 m-auto pt-4" style="border-radius:5px; background:#FFF;">
    <p class="text-center">{{ $calendar->getTitle() }}</p>
    <div class="w-75 m-auto" style="border-radius:5px;">
      <a href="javascript:void(0);">{!! $calendar->render() !!}</a>

        <!-- モーダル構造 -->
          <div id="deleteModal" class="custom-modal">
            <div class="modal-content open-modal">
              <div class="modal-body">
                <div class="reserve_date">予約日：
                  <p class="reserve_date"></p></div>
                <div class="reservePart">時間：
                  <p class="reservePart"></p></div>

                <p>上記の予約をキャンセルしてもよろしいですか？</p>
              </div>
              <div class="modal-footer">
                <span class="btn-btn cancel-modal" reserve_date="" reservePart="">閉じる</span>
                <a href="{{ route('deleteParts') }}" method="POST" class="d-inline">
                  @csrf <!-- CSRFトークンを追加 -->
                  <button type="submit" class="btn btn-danger id="reserveParts">キャンセル</button>
                </a>
              </div>
            </div>
          </div>
      </div>
        <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
    </div>
  </div>
</div>
</x-sidebar>
