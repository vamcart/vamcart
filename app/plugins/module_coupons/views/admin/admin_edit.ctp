<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

	$coupon_id = $this->data['ModuleCoupon']['id'];
	echo $form->create('ModuleCoupon', array('action' => '/module_coupons/admin/admin_edit/'.$coupon_id, 'url' => '/module_coupons/admin/admin_edit/'.$coupon_id));

	echo $admin->StartTabs();
		echo $admin->CreateTab('main');
		echo $admin->CreateTab('restrictions');			
	echo $admin->EndTabs();
	
echo $admin->StartTabContent('main');
	echo $form->inputs(array(
		'fieldset' => 'CouponFieldset',
			'ModuleCoupon/id' => array(
				'type' => 'hidden'
             ),
			'ModuleCoupon/name' => array(
				'label' => 'Name'
             ),			 
			'ModuleCoupon/code' => array(
				'label' => 'Coupon Code'
             ),
			'ModuleCoupon/free_shipping' => array(
				'label' => 'Free Shipping',
				'options' => $free_shipping_options
             ),
			'ModuleCoupon/percent_off_total' => array(
				'label' => 'Percent Off Total'
             ),
			'ModuleCoupon/amount_off_total' => array(
				'label' => 'Amount Off Total'
             )
   ));
echo $admin->EndTabContent();   

echo $admin->StartTabContent('restrictions');
	echo $form->inputs(array(
			'fieldset' => 'CouponFieldset',
			'ModuleCoupon/max_uses' => array(
				'label' => 'Max Uses',
				'value' => (empty($this->data)?1000:$this->data['ModuleCoupon']['max_uses'])
             ),
			'ModuleCoupon/min_product_count' => array(
				'label' => 'Min Product Count'
             ),
			'ModuleCoupon/max_product_count' => array(
				'label' => 'Max Product Count'
             ),
			'ModuleCoupon/min_order_total' => array(
				'label' => 'Min Order Total'
             ),
			'ModuleCoupon/max_order_total' => array(
				'label' => 'Max Order Total'
             )
	));
echo $admin->EndTabContent();   


	echo $form->submit( __('form_submit', true), array('name' => 'submitbutton', 'id' => 'submitbutton')) . $form->submit( __('form_apply', true), array('name' => 'applybutton')) . $form->submit( __('form_cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clearb"></div>';
	echo $form->end();
?>