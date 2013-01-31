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

$this->Html->script(array(
    'jquery/plugins/jquery-ui-min.js',
    'lou-multi-select/jquery.multi-select.js',
    'lou-multi-select/jquery.quicksearch.js',
    'selectall.js',
    'admin_geo_zones.js',
    $fname
), array('inline' => false));

echo $this->Html->css('jquery-ui.css', null, array('inline' => false));
echo $this->Html->css('multi-select.css', null, array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, '');
echo $this->Form->create('GeoZoneZones', array('action' => '/geo_zones/admin_modify_country_zones_selected/', 'url' => '/geo_zones/admin_modify_country_zones_selected/'));
echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Code'), __('Name'), __('Country'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data['CountryZone'] as $country_zone)
{
	echo $this->Admin->TableCells(
		array($country_zone['code'],
			array($country_zone['name'], array('allign' => 'left')),
			array($country_zone['country_name'], array('allign' => 'left', 'width' => '100%')),
			array($this->Admin->ActionButton('delete','/geo_zones/admin_country_zone_unlink/' . $country_zone['id'] . '/' . $country_zone['geo_zone_id'], __('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $country_zone['id'])), array('align'=>'center'))
		)
	);
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')), false);
echo $this->Admin->formButton(__('Create New'), 'add.png', array('type' => 'button', 'name' => 'addbutton', 'onclick' => 'onCreateNew()'));
echo $this->Admin->formButton(__('Cancel'), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
echo $this->Form->hidden('geo_zone_id', array('value' => $geo_zone_id));
echo $this->Form->end();
echo $this->Admin->ShowPageHeaderEnd(); 
?>