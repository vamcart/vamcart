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
	return $(\'<div id="statuses-dialog"></div>\').load(\''. BASE . '/module_abandoned_carts/admin/admin_order_statuses/\').dialog({
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

	echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-cart-error');

	echo $this->Form->create('Order', array('action' => '/module_abandoned_carts/admin/admin_modify_selected/', 'url' => '/module_abandoned_carts/admin/admin_modify_selected/', 'onsubmit' => 'return beforeSubmit(this);'));

			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Report'), 'cus-application');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');			
			echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('main');
echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Customer'), __('Order Number'), __('Total'),__('Number of Products'), __('Date Placed'), __('Phone'), __('Email'), __('Customer Notified'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));
foreach($data AS $order)
{
	echo $this->Admin->TableCells(
		  array(
			($order['Order']['bill_name'] == '') ? __('No data') : $order['Order']['bill_name'],
			$order['Order']['id'],
			$order['Order']['total'],
			count($order['OrderProduct']),
			$this->Time->i18nFormat($order['Order']['created']),
			($order['Order']['phone'] == '') ? __('No data') : $order['Order']['phone'],
			($order['Order']['email'] == '') ? __('No data') : $order['Order']['email'],
			array($order['OrderComment'][0]['sent_to_customer'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False'))), array('align'=>'center')),
			array($this->Admin->ActionButton('delete','/module_abandoned_carts/admin/admin_delete/' . $order['Order']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $order['Order']['id'])), array('align'=>'center'))
		   ));
}

echo '</table>';
echo $this->Admin->EmptyResults($data);

echo $this->Admin->EndTabContent();
echo $this->Admin->StartTabContent('options');

echo $this->Html->link(__('Click here to purge all Abandoned Carts.'),'/module_abandoned_carts/admin/purge_old_carts/',null,__('Are you sure?'));
	
echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Admin->ActionBar(array('delete'=>__('Delete'), 'change_status'=>__('Notify Customer'),), false);

echo $this->Form->end();
?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>
<?php
echo $this->Admin->ShowPageHeaderEnd();
