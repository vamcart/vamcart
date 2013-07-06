<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_flash_message($params, $template)
{

	App::uses('SessionHelper', 'View/Helper');
	$Session =& new SessionHelper(new View(null));

	$result = $Session->flash();

	return $result;
}

function smarty_help_function_flash_message() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays $this->Session->flash() message.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{flash_message}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_flash_message() {
}
?>