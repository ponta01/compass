$(function () {
  $('.accordion_button').on("click", function () {
    $('.search_conditions_inner').slideToggle();
    $(this).next().slideToggle(300);
    $(this).toggleClass("open", 300);
  });

  $('.subject_edit_btn').on("click", function () {
    $(this).next().slideToggle(300);
    $(this).toggleClass("open", 300);
    // $('.subject_inner').slideToggle();
  });
});
