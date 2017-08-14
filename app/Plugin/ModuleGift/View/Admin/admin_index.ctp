<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-calculator');

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __d('module_gift', 'Gift'), __d('module_gift', 'Order Total'), __('Action')));

foreach ($gifts AS $gift)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($gift['ModuleGift']['name'],'/module_gift/admin/admin_edit/' . $gift['ModuleGift']['id']),
			$gift['ModuleGift']['order_total'],
			$this->Admin->ActionButton('edit','/module_gift/admin/admin_edit/' . $gift['ModuleGift']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/module_gift/admin/admin_delete/' . $gift['ModuleGift']['id'],__('Delete'))
		   ));
}
echo '</table>';

echo $this->Admin->EmptyResults($gifts);

echo $this->Admin->CreateNewLink();

echo $this->Admin->ShowPageHeaderEnd();

?>