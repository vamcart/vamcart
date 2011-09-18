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

	echo $form->create('License', array('id' => 'contentform', 'action' => '/license/admin_edit/', 'url' => '/license/admin_edit/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Key:', true),
				   'License.id' => array(
				   		'type' => 'hidden'
	               ),
	               'License.licenseKey' => array(
				   		'label' => __('Key:', true)
	               )
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();

	echo $admin->ShowPageHeaderEnd();

?>