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

	echo $admin->ShowPageHeaderStart($current_crumb, 'copy.png');

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_copy/' . $template['Template']['id'], 'url' => '/templates/admin_copy/' . $template['Template']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Copy Template', true),
					'Template.id' => array(
						'type' => 'hidden',
						'value' =>  $template['Template']['id']
	               ),
					'Template.name' => array(
						'type' => 'text',
						'label' => __('Template Copy Name', true) . ': '
	               )										   																
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>