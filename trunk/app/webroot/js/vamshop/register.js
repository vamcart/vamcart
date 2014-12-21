$(document).ready(function() {
  // validate form
  $("#contentform").validate({
    rules: {
      "customer[name]": {
        required: true,
        minlength: 2      
     },
      "customer[email]": {
        required: true,
        minlength: 6,
        email: true      
     },
		"customer[password]": {
			required: true,
			minlength: 5,
		},
		"customer[retype]": {
			required: true,
			minlength: 5,
			equalTo: "#password"
		}
    },
    messages: {
      "customer[name]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 2"
      },
      "customer[email]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 6"
      },
      "customer[password]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 5"
      },
      "customer[retype]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 5"
      }
    }
  });
});