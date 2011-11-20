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

	echo $admin->ShowPageHeaderStart($current_crumb, 'license.png');

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
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();

	echo $admin->ShowPageHeaderEnd();

?>