<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

echo __('Date: ') . $time->niceShort($data['ModuleReview']['created']);
echo '<br /><br />';
echo __('Author: ') . $data['ModuleReview']['name'];
echo '<br /><br />';
echo __('Review: ') . $data['ModuleReview']['content'];
echo '<br /><br />';
echo $html->link(__('Return to menu'),'/module_reviews/admin/admin_index/',array('class' => 'button'));

echo $admin->ShowPageHeaderEnd();

?>