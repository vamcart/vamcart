<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'import.png');

	echo $form->create('ImportExport', array('enctype' => 'multipart/form-data', 'id' => 'contentform', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('YML Import', true),
				   'ImportExport.submittedfile' => array(
				   	'type' => 'file',
				   	'label' => __('YML Import', true),
						'between'=>'<br />'
	               )
		 ));

	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $form->end();

echo $admin->ShowPageHeaderEnd();

?>