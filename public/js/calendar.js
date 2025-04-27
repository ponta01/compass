document.addEventListener('DOMContentLoaded', function () {
  // モーダル要素を取得
  const modal = document.getElementById('deleteModal');
  const openModalButtons = document.querySelectorAll('.open-modal');
  const closeModalButtons = document.querySelectorAll('.close-modal, .cancel-modal');

  // モーダルを開く
  openModalButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      // モーダルを表示（CSSのflexを適用）
      modal.style.display = 'flex';

      // reserve_part と reserve_date 属性を取得
      const reservePart = button.getAttribute('reserve_part');
      const reserveDate = button.getAttribute('reserve_date');

      // モーダル内のテキストを設定
      document.querySelector('.reservePart p').textContent = reservePart;
      document.querySelector('.reserve_date p').textContent = reserveDate;

      // 隠しフィールドにも値を設定
      document.querySelector('input[name="reservePart"]').value = reservePart;
      document.querySelector('input[name="reserve_date"]').value = reserveDate;
    });
  });

  // モーダルを閉じる
  closeModalButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      modal.style.display = 'none'; // モーダルを非表示
    });
  });

  // モーダル外をクリックした場合に閉じる
  modal.addEventListener('click', function (event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
});

$(function () {
$('.modal-open').on('click', function () {
  $('.custom-modal').fadeIn();
  var setting_date = $(this).attr('reserve_date_view');// 予約日の文字列
  $('.reserve_date').text(setting_date);
  var setting_part = $(this).attr('reserve_part');
  $('.reserve_part').val(setting_part);// 部数の数字
    return false;
  });
  $('.cancel-modal').on('click', function () {
    $('.custom-modal').fadeOut();
    return false;
  });
  });
