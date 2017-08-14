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

	echo $this->Form->create('ModuleGift', array('id' => 'contentform', 'url' => '/module_gift/admin/admin_index/'));

	$i = 0;
	foreach ($payment_methods AS $payment_method)
	{

	echo $this->Form->input('ModuleGift.'.$i.'.id', array(
				'type' => 'hidden',
				'value' => $payment_method['PaymentMethod']['id']
             ));
	echo $this->Form->input('ModuleGift.'.$i.'.payment_method_id', array(
				'type' => 'hidden',
				'value' => $payment_method['PaymentMethod']['id']
             ));
	echo $this->Form->input('ModuleGift.'.$i.'.discount', array(
				'label' => $payment_method['PaymentMethod']['name'].' '.__d('module_gift', 'Gift').':',
				'after' => '<span class="help-inline">%</span>',
				'class' => 'input-mini',
				'value' => $this->requestAction( '/module_gift/admin/get_gift/'.$payment_method['PaymentMethod']['id'], array('return'))
             ));			 

	$i++;
	}

	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();

?>