<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$search_form  = $this->Form->create('Search', array('action' => '/orders/admin_search/', 'url' => '/orders/admin_search/'));
$search_form .= $this->Form->input('Search.term',array('label' => __('Search'),'value' => __('Order Search'),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
$search_form .= $this->Form->submit( __('Submit'));
$search_form .= $this->Form->end();

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cart', $search_form);

echo $this->Form->create('Order', array('action' => '/orders_edit/admin/', 'url' => '/orders_edit/admin/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(__('Customer'),__('Order Number'),__('Total'), __('Date'), __('Status'), __('Action')));

foreach ($data AS $order)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($order['Order']['bill_name'],'/orders/admin_view/' . $order['Order']['id']),
				$order['Order']['id'],
				$order['Order']['total'],
				$this->Time->timeAgoInWords($order['Order']['created']),
				$order['OrderStatus']['OrderStatusDescription']['name'],
				array($this->Admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View')) . $this->Admin->ActionButton('edit','/orders_edit/admin/edit/' . $order['Order']['id'],__('Edit'))  . $this->Admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'],__('Delete')), array('align'=>'center'))
                                //array($this->Ajax->link('view', 'null', $options = array('escape' => false, 'url' => '/orders/admin_view/' . $order['Order']['id'], 'update' => 'content'), null, false), array('align'=>'center'))
		   ));
}
echo '</table>';
echo $this->Admin->EmptyResults($data);

echo '<div class="clear"></div>';
echo $this->Admin->formButton(__('New Order'), 'cus-cart-add', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));
echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>