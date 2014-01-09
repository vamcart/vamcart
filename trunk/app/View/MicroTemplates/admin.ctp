<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-layout-content');

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Alias'), __('Call (Template Placeholder)'),  __('Action')));

foreach ($micro_templates AS $micro_template)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($micro_template['MicroTemplate']['alias'],'/micro_templates/admin_edit/' . $micro_template['MicroTemplate']['id']),
			'{' . $micro_template['MicroTemplate']['tag_name'] . ' template=\'' . $micro_template['MicroTemplate']['alias'] . '\'}',
			array($this->Admin->ActionButton('edit','/micro_templates/admin_edit/' . $micro_template['MicroTemplate']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/micro_templates/admin_delete/' . $micro_template['MicroTemplate']['id'],__('Delete')), array('align'=>'center'))
		   ));
}
echo '</table>';
echo $this->Admin->CreateNewLink();
echo $this->Admin->CreateExportLink();
echo $this->Admin->CreateImportLink();

echo $this->Admin->ShowPageHeaderEnd();

?>