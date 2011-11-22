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

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Tax', array('id' => 'contentform', 'action' => '/taxes/admin_edit/', 'url' => '/taxes/admin_edit/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Tax Details', true),
				   'Tax.id' => array(
				   		'type' => 'hidden'
	               ),
	               'Tax.name' => array(
				   		'label' => __('Name', true)
	               )					     				   	   																									
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
?>