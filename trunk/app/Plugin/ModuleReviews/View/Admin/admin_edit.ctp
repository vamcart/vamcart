<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

echo __('Date: ') . $this->Time->i18nFormat($data['ModuleReview']['created']);
echo '<br /><br />';
echo __('Author: ') . $data['ModuleReview']['name'];
echo '<br /><br />';
echo __('Rating: ') . $data['ModuleReview']['rating'];
echo '<br /><br />';
echo __('Review: ') . $data['ModuleReview']['content'];
echo '<br /><br />';
echo $this->Admin->linkButton(__('Return to menu'),'/module_reviews/admin/admin_index/','cus-arrow-left',array('escape' => false, 'class' => 'btn'));
echo $this->Admin->ShowPageHeaderEnd();

?>