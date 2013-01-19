<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'coupons.png');

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Name'), __('Code'), __('Action')));

foreach ($coupons AS $coupon)
{
	echo $admin->TableCells(
		  array(
			$html->link($coupon['ModuleCoupon']['name'],'/module_coupons/admin/admin_edit/' . $coupon['ModuleCoupon']['id']),
			$coupon['ModuleCoupon']['code'],
			$admin->ActionButton('edit','/module_coupons/admin/admin_edit/' . $coupon['ModuleCoupon']['id'],__('Edit')) . $admin->ActionButton('delete','/module_coupons/admin/admin_delete/' . $coupon['ModuleCoupon']['id'],__('Delete'))
		   ));
}
echo '</table>';

echo $admin->EmptyResults($coupons);

echo $admin->CreateNewLink();

echo $admin->ShowPageHeaderEnd();

?>