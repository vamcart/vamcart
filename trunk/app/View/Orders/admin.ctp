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

if (!file_exists(WWW_ROOT . 'js/' . $fname)) {
	$fname = 'admin_content_i18n_en.js';
}
    
$this->Html->script(array(
	'jquery/plugins/jquery-ui-min.js',
	'selectall.js',
	$fname
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

echo $this->Html->css('jquery-ui.css', null, array('inline' => false));
$search_form  = $this->Form->create('Search', array('action' => '/orders/admin_search/', 'url' => '/orders/admin_search/'));
$search_form .= $this->Form->input('Search.term',array('label' => __('Search'),'value' => __('Order Search'),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
$search_form .= $this->Form->submit( __('Submit'));
$search_form .= $this->Form->end();

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cart', $search_form);

echo $this->Form->create('Order', array('action' => '/orders/admin_modify_selected/', 'url' => '/orders/admin_modify_selected/', 'onsubmit' => 'return beforeSubmit(this);'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(__('Customer'),__('Order Number'),__('Total'), __('Date'), __('Status'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $order)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($order['Order']['bill_name'],'/orders/admin_view/' . $order['Order']['id']),
				$order['Order']['id'],
				$order['Order']['total'],
				$this->Time->i18nFormat($order['Order']['created']),
				$order_status_list[$order['OrderStatus']['id']],
				array($this->Admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View')) . $this->Admin->ActionButton('edit','/orders_edit/admin/edit/' . $order['Order']['id'],__('Edit'))  . $this->Admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $order['Order']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $this->Admin->EmptyResults($data);

echo $this->Admin->ActionBar(array('delete'=>__('Delete'), 'change_status'=>__('Change Order Status'),), false);
echo $this->Form->end();

echo $this->Form->create('Order', array('action' => '/orders_edit/admin/', 'url' => '/orders_edit/admin/'));
echo $this->Admin->formButton(__('New Order'), 'cus-cart-add', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));
echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>