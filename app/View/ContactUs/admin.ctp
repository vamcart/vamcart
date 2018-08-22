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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-comments');

echo $this->Form->create('Contact', array('url' => '/contact_us/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Contact Name'), __('Contact Email'), __('Contact Message'), __('Reply Sent'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $contact_data)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($contact_data['Contact']['name'], '/contact_us/admin_edit/' . $contact_data['Contact']['id']),
				$this->Html->link($contact_data['Contact']['email'], '/contact_us/admin_edit/' . $contact_data['Contact']['id']),
				$this->Html->link(CakeText::truncate($contact_data['Contact']['message'],50,array('html' => true)), '/contact_us/admin_edit/' . $contact_data['Contact']['id']),
				array(($contact_data['Contact']['answered'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('Yes'),'title' => __('Yes'))):$this->Html->image('admin/icons/false.png', array('alt' => __('No'),'title' => __('No')))), array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/contact_us/admin_edit/' . $contact_data['Contact']['id'],__('Reply')) . $this->Admin->ActionButton('delete','/contact_us/admin_delete/' . $contact_data['Contact']['id'],__('Delete')) . $this->Admin->ActionButton('view','/contact_us/admin_view/' . $contact_data['Contact']['id'],__('Answers List')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $contact_data['Contact']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')),false);
echo $this->Form->end();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>

<?php
echo $this->Admin->ShowPageHeaderEnd();
?>