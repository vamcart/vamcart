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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-user');

echo '<table class="contentHeader">';
echo '<tr>';
echo '<td>';
echo '<div class="search-customers">';
echo $this->Form->create('Search', array('url' => '/customers/admin_search/'));
echo $this->Form->input('Search.customer_search_term',array('label' => __('Search'),'placeholder' => __('Search')));
echo $this->Form->submit( __('Submit'));
echo $this->Form->end();
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo $this->Form->create('Customer', array('url' => '/customers/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Customer Name'), __('Phone'), __('Email'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $customer)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($customer['Customer']['name'], '/customers/admin_edit/' . $customer['Customer']['id']),
				array($customer['AddressBook']['phone'], array('align'=>'center')),
				array($customer['Customer']['email'], array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/customers/admin_edit/' . $customer['Customer']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/customers/admin_delete/' . $customer['Customer']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $customer['Customer']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')));
echo $this->Form->end();
?>

<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>
<?php
echo $this->Admin->ShowPageHeaderEnd();
