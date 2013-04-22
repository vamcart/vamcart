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

echo $this->Form->create('Order', array('action' => '/orders/admin_modify_selected/', 'url' => '/orders/admin_modify_selected/'));

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
				array($this->Admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View')) . $this->Admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'],__('Delete')), array('align'=>'center'))
		   ));
		   	
}
echo '</table>';
echo $this->Admin->EmptyResults($data);

echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->prev(__('<< Previous')); ?></td>
		<td>&nbsp;<?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?>&nbsp;</td>
		<td><?php echo $this->Paginator->next(__('Next >>')); ?></td>
	</tr>
</table>