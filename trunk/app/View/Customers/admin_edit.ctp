<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));
?>
<?php echo $this->Html->scriptBlock('
  $(document).ready(function() {
    $("#ship_country").change(function () {
      $("#ship_state_div").load(\''.BASE.'/customers/generate_state_list/\' + $(this).val());
    });
  });
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php

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
   				   		'label' => __('Email')
	               ));	
	echo $this->Form->input('Customer.password', 
						array(
				   		'type' => 'password',
				   		'autocomplete' => 'off',
				   		'value' => '',				   
   				   	'label' => __('New Password'),
   				   	'after' => ' '.__('Leave empty to use current password.')
	               ));
	echo $this->Form->input('Customer.retype', 
						array(
				   		'type' => 'password',
				   		'autocomplete' => 'off',				   
				   		'value' => '',				   
   				   	'label' => __('Confirm Password'),
   				   	'after' => ' '.__('Leave empty to use current password.')
	               ));
	echo $this->Form->input('Customer.groups_customer_id',array(
				'type' => 'select',
				'label' => __('Group')
				,'options' => $groups
                                ));        
	echo '<div>'.__('Shipping Information').'</div>';	               
	echo $this->Form->input('AddressBook.ship_name', 
						array(
   				   		'label' => __('Customer Name')
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
  $country_list = $this->requestAction('/customers/generate_country_list/');            	               
  echo '<div id="country_state_div">';	   
	echo $this->Form->input('AddressBook.ship_country', 
   					array(
							'type' => 'select',
							'id' => 'ship_country',
				   		'label' => __('Country'),
							'options' => $country_list,
							'selected' => (!isset($data['AddressBook']['ship_country'])? $default_country : $data['AddressBook']['ship_country'])
	               ));
	echo '</div>';
  $state_list = $this->requestAction('/customers/generate_state_list/'.$data['AddressBook']['ship_country']);            	               
  echo '<div id="ship_state_div">';	   
	echo $this->Form->input('AddressBook.ship_state', 
   					array(
							'type' => 'select',
							'id' => 'ship_state',
				   		'label' => __('State'),
							'options' => $state_list,
							'selected' => (!isset($data['AddressBook']['ship_state'])? $default_state : $data['AddressBook']['ship_state'])
	               ));
	echo '</div>';
	echo $this->Form->input('AddressBook.ship_zip', 
						array(
   				   		'label' => __('Zip')
	               ));	
	echo $this->Form->input('AddressBook.phone', 
						array(
   				   		'label' => __('Phone')
	               ));

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
