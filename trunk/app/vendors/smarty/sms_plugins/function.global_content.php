<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

function smarty_function_global_content($params, &$smarty)
{
	// Cache the output.
	$cache_name = 'sms_gcb_output_' .  $params['alias'];
	$output = Cache::read($cache_name);
	if($output === false)
	{
		ob_start();

	global $content;
		
	// Load the smarty component because we're coming from a plugin
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();
	
	// Load the template model and get the sub-template from the databse
	App::import('Model', 'GlobalContentBlock');
		$GlobalContentBlock =& new GlobalContentBlock();

	$gcb = $GlobalContentBlock->find(array('alias' => $params['alias']));

	$Smarty->display($gcb['GlobalContentBlock']['content'],$smarty->_tpl_vars);
		
		
		// Write the output to cache and echo them
		$output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $output);		
	}
	echo $output;	
		
}

function smarty_help_function_global_content() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Outputs the global_content of the current page, product, or category depending on the user\'s default selected language.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{global_content alias='footer'}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(alias)') ?></em> - <?php echo __('Alias of the global content block to display.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_global_content() {
	?>
	<p><?php echo __('Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>') ?>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>
