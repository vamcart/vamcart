  $(document).ready(function() {
    $("#ship_country").change(function () {
      $("#ship_state_div").load("{base_path}/countries/address_book_regions/" + $(this).val());
    });
  });

$(document).ready(function() {

$("#ship_phone").mask("(999) 999-9999");

  // validate form
  $("#contentform").validate({
    rules: {
      "AddressBook[ship_name]": {
        required: true,
        minlength: 3      
     },
      "AddressBook[ship_line_1]": {
        required: true,
        minlength: 3,
     },
		//"AddressBook[ship_line_2]": {
			//required: true,
			//minlength: 3,
		//},
		"AddressBook[ship_city]": {
			required: true,
			minlength: 3,
		},
      "AddressBook[ship_country]": {
        required: true,
     },
      //"AddressBook[ship_state]": {
        //required: true,
     //},
		"AddressBook[ship_zip]": {
			required: true,
			minlength: 3,
		},
		"AddressBook[phone]": {
			required: true,
			minlength: 3,
		}
    },
    messages: {
      "AddressBook[ship_name]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[ship_line_1]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      //"AddressBook[ship_line_2]": {
        //required: "{lang}Required field{/lang}",
        //minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      //},
      "AddressBook[ship_city]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[ship_country]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      //"AddressBook[ship_state]": {
        //required: "{lang}Required field{/lang}",
      //},
      "AddressBook[ship_zip]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[phone]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      }
    }
  });
});