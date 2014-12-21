$(document).ready(function() {
  // validate form
  $("#contentform").validate({
    rules: {
      name: {
        required: true,
        minlength: 3      
     },
      email: {
        required: true,
        minlength: 3      
     },
      message: {
        required: true,
        minlength: 3      
     },
    },
    messages: {
      name: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      email: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      message: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      }
    }
  });
});