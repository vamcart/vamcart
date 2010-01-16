<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

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

?>