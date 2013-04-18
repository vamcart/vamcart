<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'payment-methods.png');

	echo $this->Form->create('AddModule', array('enctype' => 'multipart/form-data', 'id' => 'contentform', 'action' => '/tags/admin_upload/', 'url' => '/tags/admin_upload/'));

	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Upload New Module'),
				   'AddModule.submittedfile' => array(
				   	'type' => 'file',
				   	'label' => __('Upload New Module'),
						'between'=>'<br />'
	               )
		 ));

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();
	
?>