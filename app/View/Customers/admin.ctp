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

	if (\'send_message\' == action) {
		var dialog = sendMessage(form);
		return false;
	} else {
		return true;
	}
}

function sendMessage(form)
{
	return $(\'<div id="statuses-dialog"></div>\').load(\''. BASE . '/customers/admin_send_message/\').dialog({
		modal: true,
		title: i18n.SendMessage,
		width: 600,
		height: 600,
		buttons: [{
			text: i18n.Submit,
			click: function () {
				submit_flag = true;
				var message = $("#message").val();
				$(form).append(\'<input type="hidden" name="message" />\');
				$("input[name=message]").val(message);
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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-user');

echo '<table class="contentHeader">';
echo '<tr>';
echo '<td>';
echo '<div class="search-customers">';
echo $this->Form->create('Search', array('url' => '/customers/admin_search/'));
echo $this->Form->input('Search.customer_search_term',array('label' => __('Search'),'placeholder' => __('Search')));
echo $this->Form->submit( __('Submit'));
echo $this->Form->end();
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo $this->Form->create('Customer', array('url' => '/customers/admin_modify_selected/', 'onsubmit' => 'return beforeSubmit(this);'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Customer Name'), __('Phone'), __('Email'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $customer)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($customer['Customer']['name'], '/customers/admin_edit/' . $customer['Customer']['id']),
				array($customer['AddressBook']['phone'], array('align'=>'center')),
				array($customer['Customer']['email'], array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/customers/admin_edit/' . $customer['Customer']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/customers/admin_delete/' . $customer['Customer']['id'],__('Delete')) . $this->Admin->ActionButton('view','/customers/admin_view/' . $customer['Customer']['id'],__('Messages List')) . $this->Admin->ActionButton('import','/orders/admin/?email=' . $customer['Customer']['email'],__('Customer Orders')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $customer['Customer']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete'), 'send_message'=>__('Send Message')), false);
echo $this->Form->end();
?>

<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>
<?php
echo $this->Admin->ShowPageHeaderEnd();
