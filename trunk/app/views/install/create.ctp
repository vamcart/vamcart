<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
?>

<p>
<?php __('Database successfully imported.') ?>
</p>
<form method="post" action="http://vamcart.com/modules/evennews/index.php">
<fieldset class="form">
<legend><?php echo __('VaM Cart Newsletter', true); ?></legend>
<div class="input text"><?php echo __('Your Name', true); ?>: <input type="text" name="user_nick" /></div>
<div class="input text"><?php echo __('Your Email', true); ?>: <input type="text" name="user_mail" /></div>
</fieldset>
<input type='hidden' name='action' value='subscribe_conf'>
<span class="button"><button type="submit" value="<?php echo __('Submit', true); ?>"><?php echo __('Submit', true); ?></button></span>
</form>
<p>
<?php echo __('We at VaM Cart value your privacy, we will never sell or distribute your information. You will only receive information regarding VaM Cart or its affiliates.', true); ?>
</p>
<p>
<?php echo __('At anytime you may remove yourself from the list if you think you joined in error.', true); ?>
</p>
<p>
<?php echo $html->link(__('Click here to visit your live store.',true),'/', array('target'=>'_blank')); ?>
</p>
