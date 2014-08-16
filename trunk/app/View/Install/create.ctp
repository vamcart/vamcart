<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-lightbulb');
?>
<p>
<?php echo __('Database successfully imported.') ?>
</p>
<p>
<?php echo $this->Admin->linkButtonCatalog(__('Click here to visit your live store.'),'/','cus-cart-go',array('escape' => false, 'target'=>'_blank', 'class' => 'btn')); ?>
</p>
<p><?php echo __('VamShop Newsletter'); ?>: </p>
<p>
<?php echo $this->Admin->linkButtonCatalog(__('Subscribe'),__('http://support.vamshop.com/modules/evennews/index.php?action=subscribe'),'cus-arrow-right',array('escape' => false, 'target'=>'_blank', 'class' => 'btn'));
 ?>
</p>
<p>
<?php echo __('We at VamShop value your privacy, we will never sell or distribute your information. You will only receive information regarding VamShop or its affiliates.'); ?>
</p>
<p>
<?php echo __('At anytime you may remove yourself from the list if you think you joined in error.'); ?>
</p>
<?php
echo $this->Admin->ShowPageHeaderEnd();
?>