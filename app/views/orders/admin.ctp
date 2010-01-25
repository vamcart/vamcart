<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'orders.png');

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
