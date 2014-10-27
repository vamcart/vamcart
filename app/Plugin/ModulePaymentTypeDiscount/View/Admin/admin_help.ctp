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
<p><?php echo __d('module_payment_type_discount', 'The payment type discount module allows you to create discounts for payment methods.'); ?></p>
<h3><?php echo __('How do I use this?'); ?></h3>
<p><?php echo __d('module_payment_type_discount', 'Once installed there will be a new menu item under Configurations called Payment Type Discount. Here you can add discounts for payment methods. They will be applied during checkout.'); ?></p>
<?php echo $this->Admin->linkButton(__('Back'), '/modules/admin/', 'cus-arrow-turn-left', array('escape' => false, 'class' => 'btn')).$this->Admin->linkButton(__d('module_payment_type_discount', 'Payment Type Discount'), '/module_payment_type_discount/admin/admin_index/', 'cus-calculator', array('escape' => false, 'class' => 'btn')); ?>
<?php echo $this->Admin->ShowPageHeaderEnd(); ?>