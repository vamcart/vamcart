<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.ru
   http://vamcart.com
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function default_template_contact_us()
{
	$template = '<form method="post" action="' . BASE . '/contact_us/send_email/">';
	$template .= '
<fieldset class="form">
<legend>'.__('Contact Us', true).'</legend>
	<p>'.__('Your Name', true).': <input type="text" name="name" /></p>
	<p>'.__('Your Email', true).': <input type="text" name="email" /></p>
	<p>'.__('Message', true).': <textarea name="message"></textarea></p>
</fieldset>
<span class="button"><button type="submit" value="'.__('Send', true).'">'.__('Send', true).'</button></span>
	';		
	$template .= '</form>';
		
return $template;
}


function smarty_function_contact_us($params, &$smarty)
{
	$cache_name = 'vam_contact_us' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'];
	$results = Cache::read($cache_name);
	if($results === false)
	{	
		App::import('Component', 'Smarty');
			$Smarty =& new SmartyComponent();

		$results = $Smarty->load_template($params,'contact_us');

		Cache::write($cache_name, $results);		
	}
	
	
	return $results;
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
	?>
	<p><?php echo __('Author: Alexandr Menovchicov &lt;vam@kypi.ru&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>