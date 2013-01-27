<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'reviews.png');

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Author'), __('Date'), __('Product'), __('Action')));

foreach ($reviews AS $review)
{
	echo $admin->TableCells(
		  array(
			$html->link($review['ModuleReview']['name'],'/module_reviews/admin/admin_edit/' . $review['ModuleReview']['id']),
			$time->niceShort($review['ModuleReview']['created']),
			$review['Content']['alias'],
			$admin->ActionButton('edit','/module_reviews/admin/admin_edit/' . $review['ModuleReview']['id']) . $admin->ActionButton('delete','/module_reviews/admin/admin_delete/' . $review['ModuleReview']['id'])
		   ));
}
echo '</table>';

echo $admin->EmptyResults($reviews);

echo $admin->ShowPageHeaderEnd();

?>