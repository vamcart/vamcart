<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/


echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Author', true), __('Date', true), __('Content', true), __('Action', true)));


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


?>