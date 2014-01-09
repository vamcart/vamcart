<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-tag-blue');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'),'&nbsp;'));

foreach($files AS $tag)
{

	if(($tag[0] == 'function') || ($tag[0] == 'block'))
	{
		if((isset($tag['template']))&&($tag['template'] == 1))
			$import_link = "";
			//$import_link = $this->Html->image('admin/icons/import.png');
		else
			$import_link = "";
		
		echo $this->Admin->TableCells(array(
			$this->Html->link($tag[1],'/tags/admin_view/' . $tag[0] . '/' . $tag[1]),
			$import_link
		));
	}
}

echo '</table>';

echo $this->Admin->linkButton(__('Add module'), '/tags/admin_add/', 'cus-plugin-add', array('escape' => false, 'class' => 'btn'));

echo $this->Admin->ShowPageHeaderEnd();

?>