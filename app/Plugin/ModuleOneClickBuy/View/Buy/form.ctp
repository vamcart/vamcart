<?php if ($content_id > 0) { ?>
<script type="text/javascript" src="<?php echo BASE; ?>/js/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(function($){

    $('.form-anti-bot, .form-anti-bot-2').hide(); // hide inputs from users
    var answer = $('.form-anti-bot input#anti-bot-a').val(); // get answer
    $('.form-anti-bot input#anti-bot-q').val( answer ); // set answer into other input

    if ( $('form#buyform input#anti-bot-q').length == 0 ) {
        var current_date = new Date();
        var current_year = current_date.getFullYear();
        $('form#buyform').append('<input type="hidden" name="anti-bot-q" id="anti-bot-q" value="'+current_year+'" />'); // add whole input with answer via javascript to form
    }

});
</script>
<script type="text/javascript">
$(document).ready(function() {
  // validate form
  $("#buyform").validate({
    rules: {
      phone: {
        required: true,
        minlength: 6
     }
    },
    messages: {
      phone: {
        required: "<?php echo __d('module_one_click_buy', 'Required field'); ?>",
        minlength: "<?php echo __d('module_one_click_buy', 'Required field'); ?>. <?php echo __d('module_one_click_buy', 'Min length'); ?>: 3"
      }
    }
  });
});
</script>
<div class="row-fluid add-question">
	<h3><?php echo __d('module_one_click_buy', 'One Click Buy'). ': '. $content_name; ?></h3>
		<form action="<?php echo BASE; ?>/module_one_click_buy/buy/form/" method="post" id="buyform">
		<input type="hidden" name="content_id" value="<?php echo $content_id; ?>" />
		<div class="control-group">
			<div class="controls controls-row">
			<input class="span6" name="phone" id="phone" type="text" placeholder="<?php echo __d('module_one_click_buy', 'Your Phone (or Email)'); ?>"/>
			</div>
			<button class="btn btn-inverse btn-submit-question" type="submit" name="submit" value="<?php echo __d('module_one_click_buy', 'Submit'); ?>"><i class="fa fa-check"></i> <?php echo __d('module_one_click_buy', 'Submit'); ?></button>
			<div class="form-anti-bot" style="clear:both;">
				<strong>Current <span style="display:none;">month</span> <span style="display:inline;">ye@r</span> <span style="display:none;">day</span></strong> <span class="required">*</span>
				<input type="hidden" name="anti-bot-a" id="anti-bot-a" value="<?php echo date("Y"); ?>" />
				<input type="text" name="anti-bot-q" id="anti-bot-q" size="30" value="19" />
			</div>
			<div class="form-anti-bot-2" style="display:none;">
				<strong>Leave this field empty</strong> <span class="required">*</span>
				<input type="text" name="anti-bot-e-email-url" id="anti-bot-e-email-url" size="30" value=""/>
			</div>
		</div>
		</form>
</div>
<?php } ?>