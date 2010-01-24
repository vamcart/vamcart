<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo '<div class="page">';
echo '<h2>'.$admin->ShowPageHeader($current_crumb, 'tags.png').'</h2>';
echo '<div class="pageContent">';

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

echo '</div>';
echo '</div>';

?>