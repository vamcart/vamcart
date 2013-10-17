<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_contact_us()
{
$template = '
<script type="text/javascript" src="{base_path}/js/modified.js"></script>
<script type="text/javascript" src="{base_path}/js/focus-first-input.js"></script>
<h3>{lang}Contact Us{/lang}</h3>
<form id="contact-us" class="form-horizontal" name="contact-us" action="' . BASE . '/contact_us/send_email/" method="post">
	<div class="control-group">
		<label class="control-label" for="name">{lang}Your Name{/lang}:</label>
		<div class="controls">
			<input id="name" name="name" type="text" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="name">{lang}Your Email{/lang}:</label>
		<div class="controls">
			<input id="email" name="email" type="text" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="name">{lang}Message{/lang}:</label>
		<div class="controls">
			<textarea name="message" id="message" rows="9"></textarea>
		</div>
	</div>
	<button class="btn btn-inverse" type="submit" value="{lang}Send{/lang}"><i class="icon-ok"></i> {lang}Send{/lang}</button>
</form>
';
		
return $template;
}


function smarty_function_contact_us($params, $template)
{
	// Cache the output.
	$cache_name = 'vam_contact_us_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name);
	if($output === false)
	{
	ob_start();
	
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	$display_template = $Smarty->load_template($params,'contact_us');	
	$Smarty->display($display_template);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output);		
	}
	
	echo $output;
	
}

function smarty_help_function_contact_us() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Creates a contact us form.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{contact_us}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_contact_us() {
}
?>