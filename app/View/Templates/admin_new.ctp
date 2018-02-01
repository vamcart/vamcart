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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-add');

	echo $this->Form->create('Template', array('id' => 'contentform', 'url' => '/templates/admin_new/'));
	echo $this->Form->input('Template.name', 
						array(
				   		'label' => __('Name')
	               ));
	echo $this->Form->input('Template.parent_id', array(
				   		'type' => 'hidden',
						'value' => 0
	               ));
	echo $this->Form->input('Template.template_type_id', array(
				   		'type' => 'hidden',
						'value' => 0
	               ));
	echo $this->Form->input('Template.template', array(
				   		'type' => 'hidden',
						'value' => ''
	               ));

	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Create Template Set'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>