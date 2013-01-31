<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'events.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array(	__('Originator', true), __('Name', true)));

foreach ($event_data AS $event)
{
	echo $admin->TableCells(
		  array(
		  		$event['Event']['originator'],
				$html->link($event['Event']['alias'],'/events/admin_view/' . $event['Event']['id'])
		   ));
		   	
}

echo '</table>';

echo $admin->ShowPageHeaderEnd();

?>