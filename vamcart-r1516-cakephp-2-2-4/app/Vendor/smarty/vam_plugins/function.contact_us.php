<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_contact_us()
{
$template =
'<script type="text/javascript" src="{base_path}/js/jquery/jquery.min.js"></script>' .
'<script type="text/javascript" src="{base_path}/js/modified.js"></script>' .
'<script type="text/javascript" src="{base_path}/js/focus-first-input.js"></script>';
	$template .= '<form method="post" action="' . BASE . '/contact_us/send_email/" id="contentform">';
	$template .= '
<fieldset class="form">
<legend>{lang}Contact Us{/lang}</legend>
	<p><label for="name">{lang}Your Name{/lang}:</label> <input type="text" name="name" id="name" /></p>
	<p><label for="email">{lang}Your Email{/lang}:</label> <input type="text" name="email" id="email" /></p>
	<p><label for="message">{lang}Message{/lang}:</label> <textarea name="message" id="message"></textarea></p>
</fieldset>
<span class="button"><button type="submit" value="{lang}Send{/lang}"><img src="{base_path}/img/icons/buttons/submit.png" width="12" height="12" alt="" />&nbsp;{lang}Send{/lang}</button></span>
	';		
	$template .= '</form>';
		
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