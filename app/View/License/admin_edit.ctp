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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-lock');

	echo $this->Form->create('License', array('id' => 'contentform', 'url' => '/license/admin_edit/'));
	echo $this->Form->input('License.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('License.licenseKey', 
						array(
   				   	'label' => __('Key:')
	               ));
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();

	echo $this->Admin->ShowPageHeaderEnd();

?>