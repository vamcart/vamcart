<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-plugin-add');

	echo $this->Form->create('AddModule', array('enctype' => 'multipart/form-data', 'id' => 'contentform', 'action' => '/modules/admin_upload/', 'url' => '/modules/admin_upload/'));

	echo $this->Form->input('AddModule.submittedfile', 
					array(
						'type' => 'file',
						'label' => __('Upload New Module'),
						'between'=>'<br />'
					));

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();
	
?>