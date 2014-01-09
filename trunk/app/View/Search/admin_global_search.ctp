<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-magnifier');

$total_results = 0;

foreach($tables AS $key => $table)
{
	$model_results = count($results[$key]);
	if($model_results > 0)
	{
		echo '<table class="contentTable">';
		echo $this->Html->tableHeaders(array($table['Search']['model'] . ' - ' . $table['Search']['field']));
		
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
			
			echo $this->Admin->TableCells(
		 	 array(
			 	$this->Html->link($anchor,$table['Search']['url'] . $result[$model][$edit_field])
			));
		}
		echo '</table>';
	}
	$total_results += $model_results;
}

echo $this->Admin->EmptyResults($total_results);
echo __('Results: ') . '<strong>' . $total_results . '</strong>';

echo $this->Admin->ShowPageHeaderEnd();

?>