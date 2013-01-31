<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'update.png');

if($error == 1) echo '<p>'.__('You currently use latest version of VamCart.', true).'</p>';
if($success == 1) echo '<p>'.__('Update sucessfully finished.', true).'</p>';

echo $admin->ShowPageHeaderEnd();

?>