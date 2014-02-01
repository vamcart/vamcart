<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'selectall.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-user-comment');

echo $this->Form->create('ModuleReview', array('action' => '/module_reviews/admin/admin_modify_selected/', 'url' => '/module_reviews/admin/admin_modify_selected/'));

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Author'), __('Rating'), __('Date'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($reviews AS $review)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($review['ModuleReview']['name'],'/module_reviews/admin/admin_edit/' . $review['ModuleReview']['id']),
			$review['ModuleReview']['rating'],
			$this->Time->i18nFormat($review['ModuleReview']['created']),
			$this->Admin->ActionButton('view','/module_reviews/admin/admin_edit/' . $review['ModuleReview']['id'], __('View')) . $this->Admin->ActionButton('delete','/module_reviews/admin/admin_delete/' . $review['ModuleReview']['id'], __('Delete')),
			array($this->Form->checkbox('modify][', array('value' => $review['ModuleReview']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $this->Admin->EmptyResults($reviews);

echo $this->Admin->ActionBar(array('delete'=>__('Delete')),false);
echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>