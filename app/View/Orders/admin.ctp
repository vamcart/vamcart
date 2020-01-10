<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$l = $this->Session->read('Config.language');

if (NULL == $l) {
	$l = $this->Session->read('Customer.language');
}

$l = substr($l, 0, 2);

$fname = 'admin_content_i18n_' . $l . '.js';

if (!file_exists(WWW_ROOT . 'js/admin/' . $fname)) {
	$fname = 'admin_content_i18n_en.js';
}
    
$this->Html->script(array(
	'jquery/plugins/ui/jquery-ui.min.js',
	'admin/selectall.js',
	'admin/'.$fname
), array('inline' => false));
?>
<?php echo $this->Html->scriptBlock('

var submit_flag = false;

function beforeSubmit(form)
{
	if (submit_flag) {
		return true;
	}

	var action = form.multiaction.value;

	$(\'#statuses-dialog\').dialog(\'destroy\');

	if (\'change_status\' == action) {
		var dialog = statusSelection(form);
		return false;
	} else if (\'move\' == action) {
		var dialog = statusSelection(form);
		return false;
	} else {
		return true;
	}
}

function statusSelection(form)
{
	return $(\'<div id="statuses-dialog"></div>\').load(\''. BASE . '/orders/admin_order_statuses/\').dialog({
		modal: true,
		title: i18n.Status,
		width: 600,
		height: 600,
		buttons: [{
			text: i18n.Submit,
			click: function () {
				submit_flag = true;
				var val = $("#OrderOrderStatusId").val();
				var comment = $("#OrderCommentComment").val();
				var notify = $("#OrderCommentSentToCustomer:checked").val();
				$(form).append(\'<input type="hidden" name="status" />\');
				$("input[name=status]").val(val);
				$(form).append(\'<input type="hidden" name="comment" />\');
				$("input[name=comment]").val(comment);
				$(form).append(\'<input type="hidden" name="notify" />\');
				$("input[name=notify]").val(notify);
				$(form).submit();
				$(this).dialog("close");
			}
		}, {
			text: i18n.Cancel,
			click : function () {
				$(this).dialog("close");
			}
		}],
		close: function () {
			$("#OrderOrderStatusId").val(\'\');
			$("#OrderCommentComment").val(\'\');
			$("#OrderCommentSentToCustomer").val(\'\');
		}
	});
}', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php

echo $this->Html->css('jquery/plugins/ui/jquery-ui.css', null, array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cart');

echo '<table class="contentHeader">';
echo '<tr><td>';
echo '<div class="text-left">';
echo $this->Form->create('Order', array('url' => '/orders/admin/', 'type' => 'get'));
echo $this->Form->input('Order.status_id', 
			array(
				'type' => 'select',
	   		'fieldset' => false,
	   		'label' => false,
	   		'class' => 'select2',
				'options' => $order_status_dropdown,
				'onchange' => "this.form.submit()",
				'selected' => $status_id
         ));
echo $this->Form->end();
echo '</div>';
echo '</td>';
echo '<td>';
echo '<div class="search-orders">';
echo $this->Form->create('Search', array('url' => '/orders/admin_search/'));
echo $this->Form->input('Search.term',array('label' => __('Search'),'placeholder' => __('Order Search')));
echo $this->Form->submit( __('Submit'));
echo $this->Form->end();
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';


echo $this->Form->create('Order', array('url' => '/orders/admin_modify_selected/', 'onsubmit' => 'return beforeSubmit(this);'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(__('Customer'),__('Order Number'),__('Total'), __('Date'), __('Status'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $order)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($order['Order']['bill_name'],'/orders/admin_view/' . $order['Order']['id']),
				$order['Order']['id'],
				$order['Order']['total'],
				$this->Time->i18nFormat($order['Order']['created'], "%e %b %Y, %H:%M"),
				$order_status_list[$order['OrderStatus']['id']],
				array($this->Admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View')) . $this->Admin->ActionButton('edit','/orders_edit/admin/edit/' . $order['Order']['id'],__('Edit'))  . $this->Admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $order['Order']['id'])), array('align'=>'center'))
		   ), ($order['OrderStatus']['id'] == 1 ? 'highlight' : null), ($order['OrderStatus']['id'] == 1 ? 'highlight' : null));
}
echo '</table>';

echo $this->Admin->EmptyResults($data);

echo '<table class="contentFooter">';
echo '<tr><td>';
echo $this->Admin->linkButton(__('New Order'),'/orders_edit/admin/','cus-cart-add',array('escape' => false, 'class' => 'btn btn-default'));
echo '</td>';
echo '<td>';
echo $this->Admin->ActionBar(array('delete'=>__('Delete'), 'change_status'=>__('Change Order Status'),), false);
echo $this->Form->end();
echo '</td></tr>';
echo '</table>';
?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>
<?php
echo $this->Admin->ShowPageHeaderEnd();
