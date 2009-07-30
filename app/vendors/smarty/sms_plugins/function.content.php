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

function smarty_function_content($params, &$smarty)
{
	global $content;

	 	// Cache the output... Don't cache core pages.
	 	$cache_name = 'sms_page_content_' . $content['Content']['id'] . '_' . $_SESSION['Customer']['language_id'];
	 	$output = Cache::read($cache_name);
	 	if(($output === false)||($content['Content']['parent_id'] == '-1'))
	 	{
	 		ob_start();
		
		// Load the smarty component because we're coming from a plugin
		App::import('Component', 'Smarty');
			$Smarty =& new SmartyComponent();
		
		// Load the template model and get the sub-template from the databse
		App::import('Model', 'Template');
			$Template =& new Template();
			
		$template = $Template->find(array('parent_id' => $content['Template']['id'], 'template_type_id' => $content['ContentType']['template_type_id']));
			
		$Smarty->display($template['Template']['template'],$smarty->_tpl_vars);
			// Write the output to cache and echo them
			$output = @ob_get_contents();
			ob_end_clean();
			Cache::write($cache_name, $output);
		}
		echo $output;
}

function smarty_help_function_content () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('This is where the content for your page will be displayed. It\'s inserted into the template and changed based on the current page being displayed. This tag will call any sub-templates that are required to display the page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{content}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_content () {
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