<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_admin_area_link($params, $template)
{
	if(!empty($_SESSION['User']))
	{
		echo '<li><a href="' . BASE . '/admin/">'.__('Administration', true).'</a></li>';
	}

}

function smarty_help_function_admin_area_link() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Creates a link to the admin area inside of the front end template.') ?></p>
	<p><?php echo __('The link will only be displayed if the user has an active admin session.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{admin_login_link}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>		
	</ul>
	<?php
}

function smarty_about_function_admin_area_link() {
}
?>