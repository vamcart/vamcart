<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-user-comment');

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Author'), __('Date'), __('Action')));

foreach ($reviews AS $review)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($review['ModuleReview']['name'],'/module_reviews/admin/admin_edit/' . $review['ModuleReview']['id']),
			$this->Time->niceShort($review['ModuleReview']['created']),
			$this->Admin->ActionButton('edit','/module_reviews/admin/admin_edit/' . $review['ModuleReview']['id']) . $this->Admin->ActionButton('delete','/module_reviews/admin/admin_delete/' . $review['ModuleReview']['id'])
		   ));
}
echo '</table>';

echo $this->Admin->EmptyResults($reviews);

echo $this->Admin->ShowPageHeaderEnd();

?>