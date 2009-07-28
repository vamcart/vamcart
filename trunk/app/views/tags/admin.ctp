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

echo $html->tableHeaders(array( __('Title', true),'&nbsp;'));

foreach($files AS $tag)
{

	if(($tag[0] == 'function') || ($tag[0] == 'block'))
	{
		if((isset($tag['template']))&&($tag['template'] == 1))
			$import_link = "";
			//$import_link = $html->image('admin/icons/import.png');
		else
			$import_link = "";
		
		echo $admin->TableCells(array(
			$html->link($tag[1],'/tags/admin_view/' . $tag[0] . '/' . $tag[1]),
			$import_link
		));
	}
}

echo '</table>';

?>