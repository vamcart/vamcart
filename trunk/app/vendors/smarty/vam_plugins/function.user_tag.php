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

function smarty_function_user_tag($params, &$smarty)
{

	App::import('Component', 'UserTagBase');
	$UserTagBase =& new UserTagBaseComponent();

	$UserTagBase->call_user_tag($params);

}

function smarty_help_function_user_tag() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Calls the user tag specified by alias') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{user_tag alias='user-agent'}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(alias)') ?></em> - <?php echo __('Alias of the user tag to call.') ?></li>
		<li><em><?php echo __('(var)') ?></em> - <?php echo __('Pass any other smarty variables or information to the user tag like:') ?> {user_tag alias='user-agent' var1='abcd' var2='1234'}.  <?php echo __('These will be available for the user tag to use in the $params array.') ?></li>		
	</ul>
	<?php
}

function smarty_about_function_user_tag() {
	?>
	<p><?php echo __('Author: Kevin Grandon &lt;kevingrandon@hotmail.com&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>