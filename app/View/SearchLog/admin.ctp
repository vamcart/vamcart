<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/selectall.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-group');

echo $this->Form->create('SearchLog', array('url' => '/search_log/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Search Keywords'), __('Number of queries'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $search_keywords)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($search_keywords['SearchLog']['keyword'], ''),
				array($search_keywords['SearchLog']['total'], array('align'=>'center')),
				array($this->Admin->ActionButton('delete','/search_log/admin_delete/' . $search_keywords['SearchLog']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $search_keywords['SearchLog']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')),false);
?>

<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>
<?php
echo $this->Admin->ShowPageHeaderEnd();