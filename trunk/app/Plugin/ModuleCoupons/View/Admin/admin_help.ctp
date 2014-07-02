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
<p><?php echo __('The coupons module allows you to create promotional discounts and coupons for your customers to use.'); ?></p>
<h3><?php echo __('How do I use this?'); ?></h3>
<p><?php echo __('Once installed there will be a new menu item under Content called Coupons. Here you can create coupons for your customers to use. They will be presented with a box during checkout to enter any promotional coupons they have.'); ?></p>
<h3><?php echo __('To use during checkout:'); ?></h3>
<p>{module alias='coupons' action='checkout_box'}</p>
<?php echo $this->Admin->ShowPageHeaderEnd(); ?>