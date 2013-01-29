<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

echo __('Date: ', true) . $time->niceShort($data['ModuleReview']['created']);
echo '<br /><br />';
echo __('Author: ', true) . $data['ModuleReview']['name'];
echo '<br /><br />';
echo __('Review: ', true) . $data['ModuleReview']['content'];
echo '<br /><br />';
echo $admin->linkButton(__('Return to menu'),'/module_reviews/admin/admin_index/','up.png',array('escape' => false, 'class' => 'button'));
echo $admin->ShowPageHeaderEnd();

?>