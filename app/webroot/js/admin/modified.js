$(document).ready(function() {
  $("form#contentform :input").change(function() {
    $("input[id='" + this.id + "']").addClass("modified");
    $("radio[id='" + this.id + "']").addClass("modified");
    $("select[id='" + this.id + "']").addClass("modified");
    $("checkbox[id='" + this.id + "']").addClass("modified");
    $("textarea[id='" + this.id + "']").addClass("modified");
  });
});