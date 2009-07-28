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