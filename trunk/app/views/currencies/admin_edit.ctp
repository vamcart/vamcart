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


	echo $form->create('Currency', array('action' => '/currencies/admin_edit/', 'url' => '/currencies/admin_edit/'));
	echo $form->inputs(array(
					'fieldset' => __('currency_details', true),
				   'Currency/id' => array(
				   		'type' => 'hidden'
	               ),
	               'Currency/name' => array(
				   		'label' => __('name', true)
	               ),
				   'Currency/code' => array(
   				   		'label' => __('code', true)
	               ),	
				   'Currency/symbol_left' => array(
   				   		'label' => __('symbol_left', true)
	               ),	
				   'Currency/symbol_right' => array(
   				   		'label' => __('symbol_right', true)
	               ),	
				   'Currency/decimal_point' => array(
   				   		'label' => __('decimal_point', true)
	               ),					   				   			
				   'Currency/thousands_point' => array(
   				   		'label' => __('thousands_point', true)
	               ),	
				   'Currency/decimal_places' => array(
   				   		'label' => __('decimal_places', true)
	               ),				 
				   'Currency/value' => array(
   				   		'label' => __('value', true)
	               )					     				   	   																									
			));
	echo $form->submit( __('form_submit', true), array('name' => 'submit')) . $form->submit( __('form_cancel', true), array('name' => 'cancel'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>