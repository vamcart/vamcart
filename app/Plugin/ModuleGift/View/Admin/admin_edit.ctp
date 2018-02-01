<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/modified.js',
	'admin/focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-application-edit');

	$gift_id = $this->data['ModuleGift']['id'];
	echo $this->Form->create('ModuleGift', array('id' => 'contentform', 'url' => '/module_gift/admin/admin_edit/'.$gift_id));

			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__d('module_gift', 'Gift'), 'cus-application');
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
echo $this->Admin->StartTabContent('main');
	echo $this->Form->input('ModuleGift.id', array(
				'type' => 'hidden'
             ));
		echo $this->Form->input('ModuleGift.content_id', 
					array(
						'type' => 'select',
			   		'label' => __d('module_gift', 'Gift'),
						'options' => $this->requestAction('/module_gift/admin/admin_products_tree/'),
						'escape' => false,
						'empty' => array(0 => __d('module_gift', 'Select Gift'))
               ));
                            	 
	echo $this->Form->input('ModuleGift.order_total', array(
				'label' => __d('module_gift', 'Order Total')
             ));
echo $this->Admin->EndTabContent();   

	echo $this->Admin->EndTabs();

	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submitbutton')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();

?>