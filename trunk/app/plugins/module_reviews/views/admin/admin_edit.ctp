<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

echo __('Date: ', true) . $time->niceShort($data['ModuleReview']['created']);
echo '<br /><br />';
echo __('Author: ', true) . $data['ModuleReview']['name'];
echo '<br /><br />';
echo __('Review: ', true) . $data['ModuleReview']['content'];
echo '<br /><br />';
echo $html->link(__('Return to menu', true),'/module_reviews/admin/admin_index/',array('class' => 'button'));

echo $admin->ShowPageHeaderEnd();

?>