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
<p><?php echo __d('module_gift', 'The gift module allows you to set gifts for customers.'); ?></p>
<h3><?php echo __('How do I use this?'); ?></h3>
<p><?php echo __d('module_gift', 'Once installed there will be a new menu item under Configurations called Gift. Here you can add gifts for customers. They will be applied during checkout.'); ?></p>
<?php echo $this->Admin->linkButton(__('Back'), '/modules/admin/', 'cus-arrow-turn-left', array('escape' => false, 'class' => 'btn btn-default')); ?>
<?php echo $this->Admin->ShowPageHeaderEnd(); ?>