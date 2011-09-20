<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'upgrade.png');

if($error == 1) echo '<p>'.__('You currently use latest version of VamCart.', true).'</p>';
if($success == 1) echo '<p>'.__('Update sucessfully finished.', true).'</p>';

echo $admin->ShowPageHeaderEnd();

?>