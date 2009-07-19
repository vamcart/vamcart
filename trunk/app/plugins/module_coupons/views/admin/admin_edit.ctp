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
	echo $form->create('ModuleCoupon', array('id' => 'contentform', 'action' => '/module_coupons/admin/admin_edit/'.$coupon_id, 'url' => '/module_coupons/admin/admin_edit/'.$coupon_id));

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true));
			echo $admin->CreateTab('restrictions',__('Restrictions',true));			
			echo '</ul>';
	
echo $admin->StartTabContent('main');
	echo $form->inputs(array(
		'fieldset' => __('Coupon Details', true),
			'ModuleCoupon/id' => array(
				'type' => 'hidden'
             ),
			'ModuleCoupon/name' => array(
				'label' => __('Name', true)
             ),			 
			'ModuleCoupon/code' => array(
				'label' => __('Coupon Code', true)
             ),
			'ModuleCoupon/free_shipping' => array(
				'label' => __('Free Shipping', true),
				'options' => $free_shipping_options
             ),
			'ModuleCoupon/percent_off_total' => array(
				'label' => __('Percent Off Total', true)
             ),
			'ModuleCoupon/amount_off_total' => array(
				'label' => __('Amount Off Total', true)
             )
   ));
echo $admin->EndTabContent();   

echo $admin->StartTabContent('restrictions');
	echo $form->inputs(array(
			'fieldset' => __('Coupon Details', true),
			'ModuleCoupon/max_uses' => array(
				'label' => __('Max Uses', true),
				'value' => (empty($this->data)?1000:$this->data['ModuleCoupon']['max_uses'])
             ),
			'ModuleCoupon/min_product_count' => array(
				'label' => __('Min Product Count', true)
             ),
			'ModuleCoupon/max_product_count' => array(
				'label' => __('Max Product Count', true)
             ),
			'ModuleCoupon/min_order_total' => array(
				'label' => __('Min Order Total', true)
             ),
			'ModuleCoupon/max_order_total' => array(
				'label' => __('Max Order Total', true)
             )
	));
echo $admin->EndTabContent();   

	echo $admin->EndTabs();

	echo $form->submit( __('Submit', true), array('name' => 'submitbutton', 'id' => 'submitbutton')) . $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clearb"></div>';
	echo $form->end();
?>