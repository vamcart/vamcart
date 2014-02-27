<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-arrow-refresh');

echo '<p>'.__('VamShop Version:').' <strong>'.$update_data->current_version.'</strong></p>';

if($update_data->current_version >= $update_data->latest_version) {	echo '<p>'.__('You have latest version of VamShop. No update needed.').'</p>';
} else { 
	echo '<p>'.__('Current VamShop Version:').' <strong>'.$update_data->latest_version.'</strong></p>';
	echo '<p>'.__('Click Update button to start VamShop AutoUpdate.').'</p>';
	echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your files and database before update at Admin - Tools - Database Backup.').'</div>';
	echo '<br />';
	echo $this->Admin->linkButton(__('Update'),'/update/admin_update/','cus-tick',array('escape' => false, 'class' => 'btn'));
} 

echo $this->Admin->ShowPageHeaderEnd();

?>