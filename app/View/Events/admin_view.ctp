<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'events.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array(	__('Originator', true),__('Action', true)));

foreach ($event_handlers AS $handle)
{
	echo $admin->TableCells(
		  array(
				$handle['EventHandler']['originator'],
				array($handle['EventHandler']['action'], array('align'=>'center'))
		   ));
		   	
}

echo '</table>';
echo $admin->EmptyResults($event_handlers);

echo $admin->ShowPageHeaderEnd();

?>