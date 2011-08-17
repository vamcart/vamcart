<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/jquery.min.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_edit_details/'.$data['Template']['id'], 'url' => '/templates/admin_edit_details/'.$data['Template']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Template Details', true),
				   'Template.id' => array(
				   		'type' => 'hidden',
						'value' => $data['Template']['id']
	               ),
	               'Template.name' => array(
				   		'label' => __('Name', true),
   						'value' => $data['Template']['name']
	               )																										
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>