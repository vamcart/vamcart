<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Html->script('jquery/jquery.min', array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'update.png');

echo '<p>'.__('Your VamCart Version:').' <strong>'.$update_data->current_version.'</strong></p>';

if($update_data->current_version < $update_data->latest_version) {	echo '<p>'.__('Current VamCart Version:').' <strong>'.$update_data->latest_version.'</strong></p>';
	echo '<p>'.__('Click Update button to start VamCart AutoUpdate.').'</p>';
	echo $this->Admin->linkButton(__('Update'),'/update/admin_update/','submit.png',array('escape' => false, 'class' => 'button'));
}

echo $this->Admin->ShowPageHeaderEnd();

?>