<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'key.png');

echo '<table class="contentTable">';

echo '<p>Ваша лицензия: <strong>'. $license_data['licenseKey'] .'</strong> '. $admin->ActionButton('edit','/license/admin_edit/' . $license_data['id'],__('Edit', true)) .'</p>';
if($license_data['check'] == 'true') {
	echo '<p>Лицензия для домена: <strong>'. $license_data['params'][0] .'</strong></p>';
	//echo '<p>Дата начала лицензии: <strong>'. $license_data['params'][1] .'</strong></p>';
	echo '<p>Дата завершения лицензии: <strong>'. $license_data['params'][1] .'</strong></p>';
} else {	echo '<p>Ваша лицензия недействительна. Обновите ключ лицензии.</p>';
}

echo '</table>';

echo $admin->EmptyResults($license_data);

if(!isset($license_data['licenseKey'])) {
	echo $admin->CreateNewLink();
}

echo $admin->ShowPageHeaderEnd();

?>