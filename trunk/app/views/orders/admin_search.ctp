<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$search_form  = $form->create('Search', array('action' => '/orders/admin_search/', 'url' => '/orders/admin_search/'));
$search_form .= $form->input('Search.term',array('label' => __('Search',true),'value' => __('Order Search',true),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
$search_form .= $form->submit( __('Submit', true));
$search_form .= $form->end();

echo $admin->ShowPageHeaderStart($current_crumb, 'orders.png', $search_form);

echo $form->create('Order', array('action' => '/orders/admin_modify_selected/', 'url' => '/orders/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array(__('Customer', true),__('Order Number', true),__('Total', true), __('Date', true), __('Status', true), __('Action', true)));

foreach ($data AS $order)
{
	echo $admin->TableCells(
		  array(
				$html->link($order['Order']['bill_name'],'/orders/admin_view/' . $order['Order']['id']),
				$order['Order']['id'],
				$order['Order']['total'],
				$time->timeAgoInWords($order['Order']['created']),
				$order['OrderStatus']['OrderStatusDescription'][0]['name'],
				array($admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View', true)) . $admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'],__('Delete', true)), array('align'=>'center'))
		   ));
		   	
}
echo '</table>';
echo $admin->EmptyResults($data);

echo $form->end();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $paginator->prev(__('<< Previous', true)); ?></td>
		<td>&nbsp;<?php echo $paginator->numbers(array('separator'=>' - ')); ?>&nbsp;</td>
		<td><?php echo $paginator->next(__('Next >>', true)); ?></td>
	</tr>
</table>

<?php echo $admin->ShowPageHeaderEnd(); ?>