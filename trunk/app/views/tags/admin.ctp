<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'tags.png');

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

echo $admin->linkButton(__('Add module',true), '/tags/admin_add/', 'add.png', array('escape' => false, 'class' => 'button'));

echo $admin->ShowPageHeaderEnd();

?>