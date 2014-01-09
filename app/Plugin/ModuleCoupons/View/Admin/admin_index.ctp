<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-calculator');

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Name'), __('Code'), __('Action')));

foreach ($coupons AS $coupon)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($coupon['ModuleCoupon']['name'],'/module_coupons/admin/admin_edit/' . $coupon['ModuleCoupon']['id']),
			$coupon['ModuleCoupon']['code'],
			$this->Admin->ActionButton('edit','/module_coupons/admin/admin_edit/' . $coupon['ModuleCoupon']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/module_coupons/admin/admin_delete/' . $coupon['ModuleCoupon']['id'],__('Delete'))
		   ));
}
echo '</table>';

echo $this->Admin->EmptyResults($coupons);

echo $this->Admin->CreateNewLink();

echo $this->Admin->ShowPageHeaderEnd();

?>