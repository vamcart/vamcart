<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-page-white-world');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Code'), __('Action')));

foreach ($zones AS $zone)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link(__($zone['CountryZone']['name']),'/country_zones/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id']),
			$zone['CountryZone']['code'],
			array($this->Admin->ActionButton('edit','/countries/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/country_zones/admin_delete/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id'],__('Delete')), array('align'=>'center'))
		   ));
}
echo '</table>';

//echo $this->Admin->ActionBar(array('delete'=>__('Delete')));
echo $this->Form->end();
echo $this->Admin->CreateNewLink($country['Country']['id']);

echo $this->Admin->ShowPageHeaderEnd();

?>