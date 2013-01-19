<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/plugins/jquery-ui-min.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Html->css('ui.tabs', null, array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	$coupon_id = $this->data['ModuleCoupon']['id'];
	echo $form->create('ModuleCoupon', array('id' => 'contentform', 'action' => '/module_coupons/admin/admin_edit/'.$coupon_id, 'url' => '/module_coupons/admin/admin_edit/'.$coupon_id));

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main'), 'main.png');
			echo $admin->CreateTab('restrictions',__('Restrictions'), 'restrictions.png');			
			echo '</ul>';
	
echo $admin->StartTabContent('main');
	echo $form->inputs(array(
		'legend' => null,
		'fieldset' => __('Coupon Details'),
			'ModuleCoupon.id' => array(
				'type' => 'hidden'
             ),
			'ModuleCoupon.name' => array(
				'label' => __('Name')
             ),			 
			'ModuleCoupon.code' => array(
				'label' => __('Coupon Code')
             ),
			'ModuleCoupon.free_shipping' => array(
				'label' => __('Free Shipping'),
				'options' => $free_shipping_options
             ),
			'ModuleCoupon.percent_off_total' => array(
				'label' => __('Percent Off Total')
             ),
			'ModuleCoupon.amount_off_total' => array(
				'label' => __('Amount Off Total')
             )
   ));
echo $admin->EndTabContent();   

echo $admin->StartTabContent('restrictions');
	echo $form->inputs(array(
			'legend' => null,
			'fieldset' => __('Coupon Details'),
			'ModuleCoupon.max_uses' => array(
				'label' => __('Max Uses'),
				'value' => (empty($this->data)?1000:$this->data['ModuleCoupon']['max_uses'])
             ),
			'ModuleCoupon.min_product_count' => array(
				'label' => __('Min Product Count')
             ),
			'ModuleCoupon.max_product_count' => array(
				'label' => __('Max Product Count')
             ),
			'ModuleCoupon.min_order_total' => array(
				'label' => __('Min Order Total')
             ),
			'ModuleCoupon.max_order_total' => array(
				'label' => __('Max Order Total')
             )
	));
echo $admin->EndTabContent();   

	echo $admin->EndTabs();

	echo $admin->formButton(__('Submit'), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submitbutton')) . $admin->formButton(__('Apply'), 'apply.png', array('type' => 'submit', 'name' => 'applybutton')) . $admin->formButton(__('Cancel'), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();

?>