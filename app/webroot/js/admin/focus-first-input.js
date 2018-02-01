$(function () {
  $(window).on("load",function () {
    $('#contentform :input:text:visible:enabled:first').trigger("focus");
  });
})