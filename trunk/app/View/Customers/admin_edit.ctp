<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-user-edit');

	echo $this->Form->create('Customer', array('id' => 'contentform', 'action' => '/customers/admin_edit/', 'url' => '/customers/admin_edit/'));
	echo $this->Form->input('Customer.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('Customer.name', 
						array(
				   		'label' => __('Customer Name')
	               ));
	echo $this->Form->input('Customer.email', 
						array(
   				   		'label' => __('Code')
	               ));	
	echo $this->Form->input('Customer.password', 
						array(
				   		'type' => 'password',
   				   	'label' => __('New Password')
	               ));
	echo $this->Form->input('Customer.retype', 
						array(
				   		'type' => 'password',				   
   				   	'label' => __('Confirm Password')
	               ));
	echo '<div>'.__('Shipping Information').'</div>';	               
	echo $this->Form->input('AddressBook.ship_name', 
						array(
   				   		'label' => __('Name')
	               ));	
	echo $this->Form->input('AddressBook.ship_line_1', 
						array(
   				   		'label' => __('Address Line 1')
	               ));	
	echo $this->Form->input('AddressBook.ship_line_2', 
						array(
   				   		'label' => __('Address Line 2')
	               ));	
	echo $this->Form->input('AddressBook.ship_city', 
						array(
   				   		'label' => __('City')
	               ));	
	echo $this->Form->input('AddressBook.ship_country', 
						array(
   				   		'label' => __('Country')
	               ));	
	echo $this->Form->input('AddressBook.ship_state', 
						array(
   				   		'label' => __('State')
	               ));	
	echo $this->Form->input('AddressBook.ship_zip', 
						array(
   				   		'label' => __('Zip')
	               ));	
	echo $this->Form->input('AddressBook.ship_phone', 
						array(
   				   		'label' => __('Phone')
	               ));	
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
