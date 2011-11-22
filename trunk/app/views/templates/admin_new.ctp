<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'new.png');

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_new/', 'url' => '/templates/admin_new/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Template Details', true),				   
	               'Template.name' => array(
				   		'label' => __('Name', true)
	               )																										
			));
	echo $admin->formButton(__('Create Template Set', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>