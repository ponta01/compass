document.addEventListener('DOMContentLoaded', function () {
  // モーダル要素を取得
  const modal = document.getElementById('deleteModal');
  const openModalButton = document.querySelector('.open-modal');
  const closeModalButtons = document.querySelectorAll('.close-modal, .cancel-modal');

  // モーダルを開く
  openModalButton.addEventListener('click', function () {
    modal.style.display = 'flex';// モーダルを表示（CSSのflexを適用）
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

// $('.open-modal').on('click',function(){
//     $('.custom-modal').fadeIn();
//   var reservePart = $(this).attr('reserve_part');
//   var reserve_date = $(this).attr('reserve_date');
//     $('.reservePart p').text(reservePart);
//     $('.reserve_date p').text(reserve_date);
//     return false;
//   });
//   $('.cancel-modal').on('click', function () {
//     $('.custom-modal').fadeOut();
//     return false;
//   });
