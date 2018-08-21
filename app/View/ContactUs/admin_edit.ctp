<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/modified.js',
	'admin/focus-first-input.js'
), array('inline' => false));

	echo $this->TinyMce->init();

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

	echo $this->Form->create('Contact', array('id' => 'contentform', 'url' => '/contact_us/admin_edit/'));
	echo $this->Form->input('Contact.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('Contact.answered', 
						array(
				   		'type' => 'hidden',
				   		'value' => 1
	               ));
	echo $this->Form->input('ContactAnswer.sent_to_customer', 
						array(
				   		'type' => 'hidden',
				   		'value' => 1
	               ));
	echo $this->Form->input('Contact.name', 
						array(
				   		'label' => __('Contact Name:')

	               ));
	echo $this->Form->input('Contact.email', 
						array(
   				   		'label' => __('Contact Email:')

	               ));	

	echo $this->Form->input('Contact.message', 
		array(
			'label' => __('Contact Message:'),
			'class' => 'notinymce'
   	));	
   	
   	
	echo $this->Form->input('ContactAnswer.answer', 
		array(
			'type' => 'textarea',
   		'class' => 'pagesmalltextarea',
			'label' => __('Contact Answer:')
   	));	

	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>