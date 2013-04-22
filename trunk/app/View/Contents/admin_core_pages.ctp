<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-page');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(	 __('Title'), __('Template'), __('Action')));
//pr($content_data);
foreach ($content_data AS $content)
{

	$name_link = $this->Html->link($content['ContentDescription']['name'], '/contents/admin_core_pages_edit/' . $content['Content']['id']);
	
	echo $this->Admin->TableCells(
		  array(
				$name_link,
				__($content['Template']['name']),
				array($this->Admin->ActionButton('edit','/contents/admin_core_pages_edit/' . $content['Content']['id'],__('Edit')), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ShowPageHeaderEnd();

?>