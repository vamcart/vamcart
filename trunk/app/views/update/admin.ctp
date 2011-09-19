<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'upgrade.png');

echo '<p>'.__('Your VamCart Version:', true).' <strong>'.$update_data->current_version.'</strong></p>';
echo '<p>'.__('Current VamCart Version:', true).' <strong>'.$update_data->latest_version.'</strong></p>';

if($update_data->current_version < $update_data->latest_version) {	echo '<p>'.__('Click Update button to start VamCart AutoUpdate.', true).'</p>';
	echo $admin->linkButton(__('Update', true),'/update/admin_update/','submit.png',array('escape' => false, 'class' => 'button'));
}

echo $admin->ShowPageHeaderEnd();

?>