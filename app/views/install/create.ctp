<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
?>
<?php
echo $admin->ShowPageHeaderStart($current_crumb, 'install.png');
?>
<p>
<?php __('Database successfully imported.') ?>
</p>
<p>
<?php echo $admin->linkButtonCatalog(__('Click here to visit your live store.',true),'/','submit.png',array('escape' => false, 'target'=>'_blank', 'class' => 'button')); ?>
</p>
<form method="post" action="http://vamcart.com/modules/evennews/index.php">
<fieldset class="form">
<legend><?php echo __('VamCart Newsletter', true); ?></legend>
<div class="input text"><?php echo __('Your Name', true); ?>: <input type="text" name="user_nick" /></div>
<div class="input text"><?php echo __('Your Email', true); ?>: <input type="text" name="user_mail" /></div>
</fieldset>
<input type='hidden' name='action' value='subscribe_conf'>
<?php echo $admin->formButtonCatalog(__('Subscribe', true), 'subscribe.png', array('type' => 'submit', 'name' => 'submitbutton')); ?>
</form>
<p>
<?php echo __('We at VamCart value your privacy, we will never sell or distribute your information. You will only receive information regarding VamCart or its affiliates.', true); ?>
</p>
<p>
<?php echo __('At anytime you may remove yourself from the list if you think you joined in error.', true); ?>
</p>
<?php
echo $admin->ShowPageHeaderEnd();
?>