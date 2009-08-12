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
echo $html->tableHeaders(array( __('Name', true), __('Code', true), __('Action', true)));


foreach ($coupons AS $coupon)
{
	echo $admin->TableCells(
		  array(
			$html->link($coupon['ModuleCoupon']['name'],'/module_coupons/admin/admin_edit/' . $coupon['ModuleCoupon']['id']),
			$coupon['ModuleCoupon']['code'],
			$admin->ActionButton('edit','/module_coupons/admin/admin_edit/' . $coupon['ModuleCoupon']['id'],__('Edit', true)) . $admin->ActionButton('delete','/module_coupons/admin/admin_delete/' . $coupon['ModuleCoupon']['id'],__('Delete', true))
		   ));
}
echo '</table>';

echo $admin->EmptyResults($coupons);

echo $admin->CreateNewLink();

?>