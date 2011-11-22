<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
?>

<fieldset>
<legend><?php __('Checking System Requirements') ?></legend>
<?php
foreach($install_checks AS $check)
{
	echo $html->image('admin/icons/'.($check['passed']=='passed'?'true.png':'false.png')) . '   ' . __('Can write to: ',true) . $check['dir'] . '<br />';
}

if(isset($fatal_error))
{
	echo '<p>' . __('An error has occured. Please correct the error and refresh the page.') . '</p>';	
}
?>
</fieldset>