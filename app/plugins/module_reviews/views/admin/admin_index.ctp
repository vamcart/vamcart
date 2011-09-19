<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'reviews.png');

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Author', true), __('Date', true), __('Product', true), __('Action', true)));

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