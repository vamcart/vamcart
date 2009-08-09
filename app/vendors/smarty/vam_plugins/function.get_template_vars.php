<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.ru
   http://vamshop.com
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function smarty_function_get_template_vars($params, &$smarty)
{
	echo '<pre>';
	echo 'TEMPLATE VARS { <br />';
	foreach($smarty->_tpl_vars AS $key => $value)
	{
		
		echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $key . ' => ';
		if(is_array($value))
			print_r($value);
		else
			echo $value . '<br />';
		
	}
	
	echo '}';
	echo '</pre>';
	return;

}

function smarty_help_function_get_template_vars() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Dumps all available smarty template variables onto the page. If you wanted to use one you would use it like:') ?> {$content_id}</p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{get_template_vars}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_get_template_vars() {
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