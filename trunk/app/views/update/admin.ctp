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

echo $admin->ShowPageHeaderStart($current_crumb, 'upgrade.png');

echo '<table class="contentTable">';

echo '<p>Текущая версия VamCart: <strong>'.$update_data->current_version.'</strong></p>';
echo '<p>Последняя версия VamCart: <strong>'.$update_data->latest_version.'</strong></p>';

if($update_data->current_version < $update_data->latest_version) {	echo '<p style="color: #FF0000">Требуется срочное обновление!</p>';
	echo '<span class="button" style="padding-bottom:15px;"><button onCLick="location.href=\''.BASE.'/update/admin_update/\'"><img src="'.BASE.'/img/admin/icons/buttons/submit.png" width="12" height="12" alt="">&nbsp;Обновить</button></span>';
}

echo '</table>';

echo $admin->ShowPageHeaderEnd();

?>