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


	echo $form->create('PaymentMethod', array('action' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id'], 'url' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id']));
	echo $form->inputs(array(
					'fieldset' => __('Payment Method Details', true),
				   'PaymentMethod/id' => array(
				   		'type' => 'hidden',
						'value' => $data['PaymentMethod']['id']
	               ),
	               'PaymentMethod/name' => array(
				   		'label' => __('Name', true),
   						'value' => $data['PaymentMethod']['name']
	               )				     				   	   																									
			));
	
	echo $this->requestAction( '/payment/admin/edit/' . $data['PaymentMethod']['id'], array('return'=>true));	
	
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>