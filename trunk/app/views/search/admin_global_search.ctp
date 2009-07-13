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

$total_results = 0;

foreach($tables AS $key => $table)
{
	$model_results = count($results[$key]);
	if($model_results > 0)
	{
		echo '<table class="pagetable" cellspacing="0">';
		echo $html->tableHeaders(array($table['Search']['model'] . ' - ' . $table['Search']['field']));
		
		$model = $table['Search']['model'];
		$field = $table['Search']['field'];
		$edit_field = $table['Search']['edit_field'];
		$alternate_anchor = $table['Search']['alternate_anchor'];
		
		foreach($results[$key] AS $result)
		{
			if((isset($result[$model][$alternate_anchor]))&&($result[$model][$alternate_anchor] != ""))
				$anchor = $result[$model][$alternate_anchor];
			else
				$anchor = $result[$model][$field];
			
			echo $admin->TableCells(
		 	 array(
			 	$html->link($anchor,$table['Search']['url'] . $result[$model][$edit_field])
			));
		}
		echo '</table>';
	}
	$total_results += $model_results;
}

echo $admin->EmptyResults($total_results);
echo __('Results: ', true) . '<strong>' . $total_results . '</strong>';

?>