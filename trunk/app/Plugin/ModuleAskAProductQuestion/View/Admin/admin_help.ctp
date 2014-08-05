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
<p><?php echo __d('module_ask_a_product_question', 'Customer can send question to store admin email about any product in your store from product page.'); ?></p>
<h3><?php echo __('How do I use this?'); ?></h3>
<h3><?php echo __d('module_ask_a_product_question', 'Template placeholder to create a link to a product question form:'); ?></h3>
<p>{module alias='ask_a_product_question' controller='get' action='ask_link'}</p>
<p><?php echo __d('module_ask_a_product_question', 'This call will create link to javascript popup window with product question form.'); ?></p>
<h3><?php echo __d('module_ask_a_product_question', 'Insert this placeholder at product page template (Admin - Layout - Template - Product Info).'); ?></h3>
<?php echo $this->Admin->ShowPageHeaderEnd(); ?>