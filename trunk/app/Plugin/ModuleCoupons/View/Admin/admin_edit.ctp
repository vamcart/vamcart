<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	$coupon_id = $this->data['ModuleCoupon']['id'];
	echo $this->Form->create('ModuleCoupon', array('id' => 'contentform', 'action' => '/module_coupons/admin/admin_edit/'.$coupon_id, 'url' => '/module_coupons/admin/admin_edit/'.$coupon_id));

			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('restrictions',__('Restrictions'), 'cus-key');			
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
echo $this->Admin->StartTabContent('main');
	echo $this->Form->input('ModuleCoupon.id', array(
				'type' => 'hidden'
             ));
	echo $this->Form->input('ModuleCoupon.name', array(
				'label' => __('Name')
             ));			 
	echo $this->Form->input('ModuleCoupon.code', array(
				'label' => __('Coupon Code')
             ));
	echo $this->Form->input('ModuleCoupon.free_shipping', array(
				'label' => __('Free Shipping'),
				'options' => $free_shipping_options
             ));
	echo $this->Form->input('ModuleCoupon.percent_off_total', array(
				'label' => __('Percent Off Total')
             ));
	echo $this->Form->input('ModuleCoupon.amount_off_total', array(
				'label' => __('Amount Off Total')
             ));
echo $this->Admin->EndTabContent();   

echo $this->Admin->StartTabContent('restrictions');
	echo $this->Form->input('ModuleCoupon.max_uses', array(
				'label' => __('Max Uses'),
				'value' => (empty($this->data)?1000:$this->data['ModuleCoupon']['max_uses'])
             ));
	echo $this->Form->input('ModuleCoupon.min_product_count', array(
				'label' => __('Min Product Count')
             ));
	echo $this->Form->input('ModuleCoupon.max_product_count', array(
				'label' => __('Max Product Count')
             ));
	echo $this->Form->input('ModuleCoupon.min_order_total', array(
				'label' => __('Min Order Total')
             ));
	echo $this->Form->input('ModuleCoupon.max_order_total', array(
				'label' => __('Max Order Total')
             ));
echo $this->Admin->EndTabContent();   

	echo $this->Admin->EndTabs();

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submitbutton')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();

?>