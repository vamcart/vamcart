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

function default_template_product_quantity()
{
$template = '
<input 
	id="product_quantity" 
	name="product_quantity" 
	class="product_quantity" 
	type="text" 
	value="1" 
/>
';		

return $template;
}


function smarty_function_product_quantity($params, &$smarty)
{
	$cache_name = 'sms_product_quantity' . (isset($params['template'])?'_'.$params['template']:'');
	$results = Cache::read($cache_name);
	if($results === false)
	{	
		App::import('Component', 'Smarty');
			$Smarty =& new SmartyComponent();

		$results = $Smarty->load_template($params,'product_quantity');

		Cache::write($cache_name, $results);		
	}
	
	
	return $results;
}

function smarty_help_function_product_quantity() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Creates a product quantity box.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your product_info template like:') ?> <code>{product_quantity}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_product_quantity() {
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
