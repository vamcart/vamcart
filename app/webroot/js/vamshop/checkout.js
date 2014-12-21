$(document).ready(function() {
	
$("label.shipping-method").click(function(){
$("label.shipping-method").parent().removeClass("selected");
$(this).parent().addClass("selected");
});

$("label.payment-method").click(function(){
$("label.payment-method").parent().removeClass("selected");
$(this).parent().addClass("selected");
});
});
</script>
<script type="text/javascript">
  $(document).ready(function() {
	$(hidePay);		
		function hidePay()	{
		if ($("#diff_shipping").is(":checked") == "1")
			{
		$("#diff_shipping").attr("checked", true);
		}
		else
		{
		$("#diff_shipping").attr("checked", false);
		$("#ship_information").css("display","none");
		}
		
	
		$("#diff_shipping").click(function(){
	// If checked
	        if ($("#diff_shipping").is(":checked"))
			{
	            //show the hidden div
	            $("#ship_information").show("fast");
	        }
			else
			{
			$("#ship_information").hide("fast");
			}
		});
		;}

    $("#bill_country").change(function () {
      $("#bill_state_div").load("{base_path}/countries/billing_regions/" + $(this).val());
    });
    $("#ship_country").change(function () {
      $("#ship_state_div").load("{base_path}/countries/shipping_regions/" + $(this).val());
    });
  });
  
$(document).ready(function() {
	
$("#phone").mask("(999) 999-9999");
	
  // validate form
  $("#contentform").validate({
    rules: {
      bill_name: {
        required: true,
        minlength: 2      
     },
      email: {
        required: true,
        minlength: 6,
        email: true      
     },
      phone: {
        required: true,
        minlength: 10,
     },
    },
    messages: {
      bill_name: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 2"
      },
      email: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 6"
      },
      phone: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 10"
      }
    }
  });
});