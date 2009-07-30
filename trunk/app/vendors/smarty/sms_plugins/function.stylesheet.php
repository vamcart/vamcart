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

function smarty_function_stylesheet($params, &$smarty)
{
	global $content;

	$stylesheet = '';
	
	if (isset($params['alias']) && $params['alias'] != '')
	{
		$stylesheet .= '<link rel="stylesheet" type="text/css" ';
		if (isset($params['media']) && $params['media'] != '')
		{
			$stylesheet .= 'media="' . $params['media'] . '" ';
		}
		$stylesheet .= 'href="' . BASE . '/stylesheets/load/'.$params['alias'];
		$stylesheet .= "\" />\n"; 
	}
	else
	{
		foreach ($content['Template']['Stylesheet'] AS $attached_stylesheet)
		{
			$stylesheet .= '<link type="text/css" ';
			$stylesheet .= 'href="' . BASE . '/stylesheets/load/'.$attached_stylesheet['alias'] . '.css';
			$stylesheet .= '" rel="stylesheet"  media="screen"/>'; 
		}
	}

	return $stylesheet;
}

function smarty_help_function_stylesheet() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Gets stylesheet information from the system. By default, it grabs all of the stylesheets attached to the current template.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page\'s head section like:') ?> <code>{stylesheet}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(optional)') ?></em>alias - <?php echo __('Instead of getting all stylesheets for the given page, it will only get one spefically named one, whether it\'s attached to the current template or not. Set the alias to be the ID or alias of the stylesheet.') ?></li>
		<li><em><?php echo __('(optional)') ?></em>media - <?php echo __('If name is defined, this allows you set a different media type for that stylesheet.') ?></li>
	</ul>
	</p>
	<?php
}

function smarty_about_function_stylesheet() {
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
