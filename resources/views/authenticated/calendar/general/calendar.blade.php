<x-sidebar>
<div class="vh-90 pt-4" style="background:#ECF1F6;">
  <div class="border w-75 h-95 m-auto pt-4" style="border-radius:5px; background:#FFF;">
    <p class="text-center">{{ $calendar->getTitle() }}</p>
    <div class="w-75 m-auto" style="border-radius:5px;">
      <a href="javascript:void(0);">{!! $calendar->render() !!}</a>

        <!-- モーダル構造 -->
          <div id="deleteModal" class="custom-modal">
            <div class="modal-content">
              <div class="modal-body">
                <dt>予約日：</dt>
                  <dd class="reserve_date"></dd>
                  <input type="hidden" class="reserve_date" name="reserve_date">
                <dt>時間：</dt>
                  <dd class="reserve_part"></dd>
                <input type="hidden" class="reserve_part" name="reservePart">
                <p>上記の予約をキャンセルしてもよろしいですか？</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn-btn cancel-modal">閉じる</button>
                <form action="{{ route('deleteParts') }}" method="POST" class="d-inline">
                  @csrf <!-- CSRFトークンを追加 -->
                  <button type="submit" class="btn btn-danger">キャンセル</button>
                </form>
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
