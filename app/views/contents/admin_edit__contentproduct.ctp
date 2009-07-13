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

$tax_options = $this->requestAction('/contents/generate_tax_list/');


	echo $form->inputs(array(
	   'ContentProduct/price' => array(
   		'label' => __('Price', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['price']
	   ),
	   'ContentProduct/tax_id' => array(
   		'label' => __('Tax Class', true),
		'type' => 'select',
		'options' => $tax_options,
		'selected' => $data['ContentProduct']['tax_id']
	   ),
	   'ContentProduct/stock' => array(
   		'label' => __('Stock', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['stock']
	   ),
	   'ContentProduct/model' => array(
   		'label' => __('Model', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['model']
	   ),
	   'ContentProduct/weight' => array(
   		'label' => __('Weight', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['weight']
	   )
	));
?>