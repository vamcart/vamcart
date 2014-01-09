<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>

<?php
foreach($install_checks AS $check)
{
	if ($check['passed']=='failed')
	echo $this->Html->image('admin/icons/false.png') . '   ' . __('Can\'t write to: ') . $check['dir'] . '<br />';
}

if(isset($fatal_error))
{
	echo '<p>' . __('An error has occured. Please correct the error and refresh the page.') . '</p>';	
}
?>