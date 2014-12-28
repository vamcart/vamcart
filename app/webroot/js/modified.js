$(document).ready(function() {
  $("form#contentform :input").change(function() {
    $("input[id='" + this.id + "']").addClass("modified");
  });
});