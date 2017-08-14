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

foreach ($coupons AS $coupon)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($coupon['ModuleGift']['name'],'/module_gift/admin/admin_edit/' . $coupon['ModuleGift']['id']),
			$coupon['ModuleGift']['code'],
			$this->Admin->ActionButton('edit','/module_gift/admin/admin_edit/' . $coupon['ModuleGift']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/module_gift/admin/admin_delete/' . $coupon['ModuleGift']['id'],__('Delete'))
		   ));
}
echo '</table>';

echo $this->Admin->EmptyResults($coupons);

echo $this->Admin->CreateNewLink();

echo $this->Admin->ShowPageHeaderEnd();

?>