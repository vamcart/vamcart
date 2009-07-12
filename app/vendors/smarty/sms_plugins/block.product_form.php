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

function smarty_block_product_form($params, $product_form, &$smarty)
{
	
    if (is_null($product_form)) 
	{
        return;
    }
	
	global $content;
	
	$output = '<form method="post" action="' . BASE . '/cart/purchase_product/">
				<input type="hidden" name="product_id" value="' . $content['Content']['id'] . '">';
	$output .= $product_form;		
	$output .= '</form>';
		
	echo $output;
}

function smarty_help_function_product_form() {
	?>
	<h3>What does this do?</h3>
	<p>Wraps the product purchase button with a form.</p>
	<h3>How do I use it?</h3>
	<p>Just wrap your product purchase with: <code>{product_form}stuff{/product_form}</code></p>
	<?php
}

function smarty_about_function_product_form() {
	?>
	<p>Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>
	<p>Version: 0.1</p>
	<p>
	Change History:<br/>
	None
	</p>
	<?php
}
?>
