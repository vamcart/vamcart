<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'payment-methods.png');

	echo $form->create('AddModule', array('enctype' => 'multipart/form-data', 'id' => 'contentform', 'action' => '/payment_methods/admin_upload/', 'url' => '/payment_methods/admin_upload/'));

	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Upload New Module', true),
				   'AddModule.submittedfile' => array(
				   	'type' => 'file',
				   	'label' => __('Upload New Module', true),
						'between'=>'<br />'
	               )
		 ));

	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	
	echo '<div class="clear"></div>';
	echo $form->end();

echo $admin->ShowPageHeaderEnd();
	
	?>