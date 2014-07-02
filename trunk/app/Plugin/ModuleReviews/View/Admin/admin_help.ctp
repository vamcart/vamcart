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
<p><?php echo __('The reviews module will allow customers to publish reviews and rate your products.'); ?></p>
<h3><?php echo __('How do I use this?'); ?></h3>
<p><?php echo __('Upon installation the Reviews Module will create a new Core Page for your store called Product Reviews.'); ?></p>
<h3><?php echo __('To create a link to a products reviews:'); ?></h3>
<p>{module alias='reviews' action='link'}</p>
<p><?php echo __('This call will create two links in your page/template. One to read reviews of the current content, and the other to publish your own review.'); ?></p>
<h3><?php echo __('To create a listing of reviews:'); ?></h3>
<p>{module alias='reviews' action='display'}</p>
<p><?php echo __('Generally called from the core page. If called from a template will display a listing of reviews for that content item.'); ?></p>
<?php echo $this->Admin->ShowPageHeaderEnd(); ?>