<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-arrow-refresh');

echo '<p>'.__('Your VamShop Version:').' <strong>'.$update_data->current_version.'</strong></p>';

if($update_data->current_version < $update_data->latest_version) {	echo '<p>'.__('Current VamShop Version:').' <strong>'.$update_data->latest_version.'</strong></p>';
	echo '<p>'.__('Click Update button to start VamShop AutoUpdate.').'</p>';
	echo $this->Admin->linkButton(__('Update'),'/update/admin_update/','cus-tick',array('escape' => false, 'class' => 'btn'));
}

echo $this->Admin->ShowPageHeaderEnd();

?>