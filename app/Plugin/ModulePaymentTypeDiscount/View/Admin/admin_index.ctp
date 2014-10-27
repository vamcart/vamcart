<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-application-edit');

	echo $this->Form->create('ModulePaymentTypeDiscount', array('id' => 'contentform', 'action' => '/module_payment_type_discount/admin/admin_index/', 'url' => '/module_payment_type_discount/admin/admin_index/'));

	$i = 0;
	foreach ($payment_methods AS $payment_method)
	{

	echo $this->Form->input('ModulePaymentTypeDiscount.'.$i.'.id', array(
				'type' => 'hidden',
				'value' => $payment_method['PaymentMethod']['id']
             ));
	echo $this->Form->input('ModulePaymentTypeDiscount.'.$i.'.payment_method_id', array(
				'type' => 'hidden',
				'value' => $payment_method['PaymentMethod']['id']
             ));
	echo $this->Form->input('ModulePaymentTypeDiscount.'.$i.'.discount', array(
				'label' => $payment_method['PaymentMethod']['name'].' '.__d('module_payment_type_discount', 'discount').':',
				'after' => '<span class="help-inline">%</span>',
				'class' => 'input-mini',
				'value' => $this->requestAction( '/module_payment_type_discount/admin/get_payment_discount/'.$payment_method['PaymentMethod']['id'], array('return'))
             ));			 

	$i++;
	}

	echo $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();

?>