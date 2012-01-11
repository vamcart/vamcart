<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
$l = $this->Session->read('Config.language');

if (NULL == $l) {
    $l = $this->Session->read('Customer.language');
}

$l = substr($l, 0, 2);

$fname = 'admin_geo_zones_i18n_' . $l . '.js';

if (!file_exists(WWW_ROOT . 'js/' . $fname)) {
	$fname = 'admin_geo_zones_i18n_en.js';
}

$html->script(array(
    'jquery/plugins/jquery-ui-min.js',
    'selectall.js',
    'admin_geo_zones.js',
    $fname
), array('inline' => false));

echo $html->css('jquery-ui.css', null, array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, '');
echo $form->create('GeoZoneZones', array('action' => '/geo_zones/admin_modify_country_zones_selected/', 'url' => '/geo_zones/admin_modify_country_zones_selected/'));
echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Code', true), __('Name', true), __('Country', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data['CountryZone'] as $country_zone)
{
	echo $admin->TableCells(
		array($country_zone['code'],
			array($country_zone['name'], array('allign' => 'left')),
			array($country_zone['country_name'], array('allign' => 'left', 'width' => '100%')),
			array($admin->ActionButton('delete','/geo_zones/admin_country_zone_unlink/' . $country_zone['id'] . '/' . $country_zone['geo_zone_id'], __('Delete', true)), array('align'=>'center')),
			array($form->checkbox('modify][', array('value' => $country_zone['id'])), array('align'=>'center'))
		)
	);
}

echo '</table>';

echo $admin->ActionBar(array('delete'=>__('Delete',true)), false);
echo $admin->formButton(__('Create New', true), 'add.png', array('type' => 'button', 'name' => 'addbutton', 'onclick' => 'onCreateNew()'));
echo $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
echo $form->hidden('geo_zone_id', array('value' => $geo_zone_id));
echo $form->end();
echo $admin->ShowPageHeaderEnd(); 
?>