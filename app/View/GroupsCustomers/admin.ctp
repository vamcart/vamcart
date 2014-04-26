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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-group');

echo $this->Form->create('Customer', array('action' => '/groups_customers/admin_modify_selected/', 'url' => '/groups_customers/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Group customer Name'),  __('Price Modifer'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $group)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($group['GroupsCustomerDescription']['name'], '/groups_customers/admin_edit/' . $group['GroupsCustomer']['id']),
                                $group['GroupsCustomer']['price'] . '%',
				array($this->Admin->ActionButton('edit','/groups_customers/admin_edit/' . $group['GroupsCustomer']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/groups_customers/admin_delete/' . $group['GroupsCustomer']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $group['GroupsCustomer']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')));
?>

<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>
<?php
echo $this->Admin->ShowPageHeaderEnd();