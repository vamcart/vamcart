<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$total_results = 0;

foreach($tables AS $key => $table)
{
	$model_results = count($results[$key]);
	if($model_results > 0)
	{
		echo '<table class="contentTable">';
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