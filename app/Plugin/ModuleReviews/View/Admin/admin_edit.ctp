<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->TinyMce->init();

echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-application-edit');

echo __('Date: ') . $this->Time->i18nFormat($data['ModuleReview']['created']);
echo '<br /><br />';
echo __('Author: ') . $data['ModuleReview']['name'];
echo '<br /><br />';
echo __('Rating: ') . $data['ModuleReview']['rating'];
echo '<br /><br />';
echo __('Product: ') . $data['ModuleReview']['product_name'];
echo '<br /><br />';
echo $this->Form->create('ModuleReview', array('id' => 'contentform', 'action' => '/module_reviews/admin/admin_edit/'.$id, 'url' => '/module_reviews/admin/admin_edit/'.$id));
echo $this->Form->input('ModuleReview.id', 
					array(
			   		'type' => 'hidden'
               ));
echo $this->Form->input('ModuleReview.content', 
					array(
			   		'label' => __('Review: '),
			   		'class' => 'pagesmalltextarea',
						'type' => 'textarea',
						'id' => 'content'
               ));
echo $this->TinyMce->toggleEditor('content');		
echo '<div class="clear"></div>';
echo $this->Admin->formButton(__('Save'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
echo $this->Form->end();
echo '<br />';
echo $this->Admin->linkButton(__('Return to menu'),'/module_reviews/admin/admin_index/','cus-arrow-left',array('escape' => false, 'class' => 'btn btn-default'));
echo $this->Admin->ShowPageHeaderEnd();

?>