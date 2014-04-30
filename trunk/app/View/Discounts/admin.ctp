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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table-editg');

echo $this->Form->create('ContentProductPrice', array('action' => '/discounts/admin_modify_selected/'.$content_product_id, 'url' => '/discounts/admin_modify_selected/'.$content_product_id));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Quantity'), __('Price'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($discount_data AS $discount)
{
	echo $this->Admin->TableCells(
		  array(
				$discount['ContentProductPrice']['quantity'],
                                array($discount['ContentProductPrice']['price'], array('align'=>'center')),
                                array($this->Admin->ActionButton('edit','/discounts/admin_edit/'. $content_product_id . '/' . $discount['ContentProductPrice']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/discounts/admin_delete/' . $content_product_id . '/' . $discount['ContentProductPrice']['id'],__('Delete')), array('align'=>'center')),
                                array($this->Form->checkbox('modify][', array('value' => $discount['ContentProductPrice']['id'])), array('align'=>'center'))
		   ));
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')), true, $content_product_id);

echo $this->Admin->ShowPageHeaderEnd();

?>
