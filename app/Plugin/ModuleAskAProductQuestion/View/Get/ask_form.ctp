<?php if ($content_id > 0) { ?>
<script type="text/javascript" src="<?php echo BASE; ?>/js/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  // validate form
  $("#askform").validate({
    rules: {
      name: {
        required: true,
        minlength: 3      
     },
      email: {
        required: true,
        minlength: 6,
        email: true      
     },
      content: {
        required: true,
        minlength: 3      
     },
    },
    messages: {
      name: {
        required: "<?php echo __d('module_ask_a_product_question', 'Required field'); ?>",
        minlength: "<?php echo __d('module_ask_a_product_question', 'Required field'); ?>. <?php echo __d('module_ask_a_product_question', 'Min length'); ?>: 3"
      },
      email: {
        required: "<?php echo __d('module_ask_a_product_question', 'Required field'); ?>",
        minlength: "<?php echo __d('module_ask_a_product_question', 'Required field'); ?>. <?php echo __d('module_ask_a_product_question', 'Min length'); ?>: 3"
      },
      content: {
        required: "<?php echo __d('module_ask_a_product_question', 'Required field'); ?>",
        minlength: "<?php echo __d('module_ask_a_product_question', 'Required field'); ?>. <?php echo __d('module_ask_a_product_question', 'Min length'); ?>: 3"
      }
    }
  });
});
</script>
<div class="row-fluid add-question">
	<h3><?php echo __d('module_ask_a_product_question', 'Ask a product question'). ': '. $content_name; ?></h3>
		<form action="<?php echo BASE; ?>/module_ask_a_product_question/get/ask_form/" method="post" id="askform">
		<input type="hidden" name="content_id" value="<?php echo $content_id; ?>" />
		<div class="control-group">
			<div class="controls controls-row">
			<input class="span4" name="name" id="name" type="text" placeholder="<?php echo __d('module_ask_a_product_question', 'Your Name'); ?>"/>
			</div>
			<div class="controls controls-row">
			<input class="span4" name="email" id="email" type="text" placeholder="<?php echo __d('module_ask_a_product_question', 'Your Email'); ?>"/>
			</div>
			<div class="controls controls-row">
			<textarea class="span10" name="content" id="content" cols="30" rows="10" placeholder="<?php echo __d('module_ask_a_product_question', 'Your Question'); ?>"></textarea>
			</div>
			<button class="btn btn-inverse btn-submit-question" type="submit" name="submit" value="<?php echo __d('module_ask_a_product_question', 'Submit'); ?>"><i class="fa fa-check"></i> <?php echo __d('module_ask_a_product_question', 'Submit'); ?></button>
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