<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-arrow-in');

	echo $this->Form->create('ImportExport', array('enctype' => 'multipart/form-data', 'id' => 'contentform', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

	echo $this->Form->input('ImportExport.submittedfile', 
						array(
				   		'type' => 'file',
				   		'label' => __('YML Import'),
							'between'=>'<br />'
	               ));

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>