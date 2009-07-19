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

echo '<p>' .__('Table based shipping can be set to work off of number of products in cart, weight of products, or total price of products. In the textarea below specify value to cost pairs with a colon followed by a comma. Example: 0:1.00,1:2.50,2:3.00. Units of measure must be integers.', true) . '</p>';

$types = array('weight' => __('Weight', true),
			   'total' => __('Total', true),
			   'products' => __('Products', true));

echo $form->inputs(array(
	'key_values/table_based_type' => array(
		'type' => 'select',
		'selected' => $data['table_based_type'],
		'label' => __('Based Off',true),
		'options' => $types
	),
	'key_values/table_based_rates' => array(
		'type' => 'textarea',
		'class' => 'pagesmalltextarea',
		'label' => __('Rates',true),
		'value' => $data['table_based_rates']
	)
	
));

?>