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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $this->Form->create('Language', array('id' => 'contentform', 'action' => '/languages/admin_edit/', 'url' => '/languages/admin_edit/'));
	echo $this->Form->input('Language.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('Language.name', 
						array(
				   		'label' => __('Name')
	               ));
	echo $this->Form->input('Language.code', 
						array(
   				   	'label' => __('Code')
	               ));
	echo $this->Form->input('Language.iso_code_2', 
						array(
   				   	'label' => __('Flag Code')
	               ));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>