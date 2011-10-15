<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Language', array('id' => 'contentform', 'action' => '/languages/admin_edit/', 'url' => '/languages/admin_edit/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Language Details', true),
				   'Language.id' => array(
				   		'type' => 'hidden'
	               ),
	               'Language.name' => array(
				   		'label' => __('Name', true)
	               ),
				   'Language.code' => array(
   				   		'label' => __('Code', true)
	               ),
				   'Language.iso_code_2' => array(
   				   		'label' => __('Flag Code', true)
	               )						   		     				   	   																									
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>