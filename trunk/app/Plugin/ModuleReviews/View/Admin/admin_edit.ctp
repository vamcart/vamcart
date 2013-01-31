<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

echo __('Date: ') . $this->Time->niceShort($data['ModuleReview']['created']);
echo '<br /><br />';
echo __('Author: ') . $data['ModuleReview']['name'];
echo '<br /><br />';
echo __('Review: ') . $data['ModuleReview']['content'];
echo '<br /><br />';
echo $this->Admin->linkButton(__('Return to menu'),'/module_reviews/admin/admin_index/','up.png',array('escape' => false, 'class' => 'button'));
echo $this->Admin->ShowPageHeaderEnd();

?>