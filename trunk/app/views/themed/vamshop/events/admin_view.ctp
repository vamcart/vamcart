<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo '<table class="contentTable">';

echo $html->tableHeaders(array(	__('Originator', true),__('Action', true)));


foreach ($event_handlers AS $handle)
{
	echo $admin->TableCells(
		  array(
				$handle['EventHandler']['originator'],
				$handle['EventHandler']['action']
		   ));
		   	
}

echo '</table>';
echo $admin->EmptyResults($event_handlers);
?>