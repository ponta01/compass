<x-sidebar>
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">

        <a href="javascript:void(0);">{!! $calendar->render() !!}</a>

        <!-- モーダル構造 -->
          <div id="deleteModal" class="custom-modal">
            <div class="modal-content">
              <div class="modal-body">
                <dt>予約日：{{ $reserve_date }}</dt>
                  <dd class="reserve_date"></dd>
                <dt>時間：{{ $reservePart }}</dt>
                  <dd class="reserve_part"></dd>
                <input type="hidden" class="reserve_part" name="reservePart">
                <p>上記の予約をキャンセルしてもよろしいですか？</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn-btn cancel-modal">閉じる</button>
                <form action="{{ route('deleteParts') }}" class="btn btn-danger">キャンセル</form>
              </div>
            </div>
          </div>
      </div>

    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
</x-sidebar>
