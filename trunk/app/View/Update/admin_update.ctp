<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-arrow-refresh');

if($error == 1) echo '<p>'.__('You currently use latest version of VamCart.').'</p>';
if($success == 1) echo '<p>'.__('Update sucessfully finished.').'</p>';

echo $this->Admin->ShowPageHeaderEnd();

?>