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


	echo $form->create('Currency', array('id' => 'contentform', 'action' => '/currencies/admin_edit/', 'url' => '/currencies/admin_edit/'));
	echo $form->inputs(array(
					'fieldset' => __('Currency Details', true),
				   'Currency/id' => array(
				   		'type' => 'hidden'
	               ),
	               'Currency/name' => array(
				   		'label' => __('Name', true)
	               ),
				   'Currency/code' => array(
   				   		'label' => __('Code', true)
	               ),	
				   'Currency/symbol_left' => array(
   				   		'label' => __('Symbol Left', true)
	               ),	
				   'Currency/symbol_right' => array(
   				   		'label' => __('Symbol Right', true)
	               ),	
				   'Currency/decimal_point' => array(
   				   		'label' => __('Decimal Point', true)
	               ),					   				   			
				   'Currency/thousands_point' => array(
   				   		'label' => __('Thousands Point', true)
	               ),	
				   'Currency/decimal_places' => array(
   				   		'label' => __('Decimal Places', true)
	               ),				 
				   'Currency/value' => array(
   				   		'label' => __('Value', true)
	               )					     				   	   																									
			));
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>