<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
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