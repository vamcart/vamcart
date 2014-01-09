<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-page-gear');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(	__('Originator'), __('Name')));

foreach ($event_data AS $event)
{
	echo $this->Admin->TableCells(
		  array(
		  		$event['Event']['originator'],
				$this->Html->link($event['Event']['alias'],'/events/admin_view/' . $event['Event']['id'])
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ShowPageHeaderEnd();

?>