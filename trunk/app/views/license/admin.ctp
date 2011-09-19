<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'key.png');

echo '<table class="contentTable">';

echo '<p>'.__('Key:', true).' <strong>'. $license_data['licenseKey'] .'</strong> '. $admin->ActionButton('edit','/license/admin_edit/' . $license_data['id'],__('Edit', true)) .'</p>';
if($license_data['check'] == 'true') {
	echo '<p>'.__('Domain:', true).' <strong>'. $license_data['params'][0] .'</strong></p>';
	//echo '<p>'.__('Start Date:', true).' <strong>'. $license_data['params'][1] .'</strong></p>';
	echo '<p>'.__('End Date:', true).' <strong>'. $license_data['params'][1] .'</strong></p>';
} else {	echo '<p>'.__('License is invalid. Check your key.', true).'</p>';
}

echo '</table>';

echo $admin->EmptyResults($license_data);

if(!isset($license_data['licenseKey'])) {
	echo $admin->CreateNewLink();
}

echo $admin->ShowPageHeaderEnd();

?>