<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

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
				$time->niceShort($order['Order']['created']),
				$order_status,
				$admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View', true)) . $admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'],__('Delete', true))
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