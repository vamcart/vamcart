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
//pr($data);
	echo $form->create('ShippingMethod', array('id' => 'shipping', 'name' => 'contentform', 'action' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id'], 'url' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id']));
		echo '<fieldset>';
		echo $form->inputs(array(
				'fieldset' => 'shipping_method_infp',
				'ShippingMethod/id' => array(
					'type' => 'hidden',
					'value' => $data['ShippingMethod']['id']
					),
				'ShippingMethod/name' => array(
					'type' => 'text',
					'value' => $data['ShippingMethod']['name']
					),					
	               ));
				  
	echo $this->requestAction( '/shipping/admin/edit/' . $data['ShippingMethod']['code'], array('return'=>true));	
	
	echo $form->submit( __('form_submit', true), array('name' => 'submit', 'id' => 'submit')) . $form->submit( __('form_cancel', true), array('name' => 'cancel'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>