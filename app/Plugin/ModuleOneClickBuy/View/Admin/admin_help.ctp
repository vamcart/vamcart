<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<?php echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-help'); ?>
<h3><?php echo __('What does this do?'); ?></h3>
<p><?php echo __d('module_one_click_buy', 'Customer can send request to store admin email about any product in your store from product page.'); ?></p>
<h3><?php echo __('How do I use this?'); ?></h3>
<h3><?php echo __d('module_one_click_buy', 'Template placeholder to create a link to a product request form:'); ?></h3>
<p>{module alias='one_click_buy' controller='buy' action='link'}</p>
<p><?php echo __d('module_one_click_buy', 'This call will create link to javascript popup window with product request form.'); ?></p>
<h3><?php echo __d('module_one_click_buy', 'Insert this placeholder at product page template (Admin - Layout - Template - Product Info).'); ?></h3>
<?php echo $this->Admin->linkButton(__('Back'), '/modules/admin/', 'cus-arrow-turn-left', array('escape' => false, 'class' => 'btn')); ?>
<?php echo $this->Admin->ShowPageHeaderEnd(); ?>