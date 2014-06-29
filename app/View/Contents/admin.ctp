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

	$(\'#categories-dialog\').dialog(\'destroy\');

	if (\'copy\' == action) {
		var dialog = categorySelection(form);
		return false;
	} else if (\'move\' == action) {
		var dialog = categorySelection(form);
		return false;
	} else {
		return true;
	}
}

function categorySelection(form)
{
	return $(\'<div id="categories-dialog"></div>\').load(\''. BASE . '/contents/admin_categories_tree/\').dialog({
		modal: true,
		title: i18n.Categories,
		height: 200,
		buttons: [{
			text: i18n.Select,
			click: function () {
				submit_flag = true;
				var val = $("#category").val();
				$(form).append(\'<input type="hidden" name="target_category" />\');
				$("input[name=target_category]").val(val);
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
			$("#category").val(\'\');
		}
	});
}', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php

echo $this->Html->css('jquery-ui.css', null, array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');

echo $this->Form->create('Content', array('action' => '/contents/admin_modify_selected/', 'url' => '/contents/admin_modify_selected/', 'onsubmit' => 'return beforeSubmit(this);'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(	 __('Title'), __('Type'), __('Active'), __('Show in menu'), __('Export to YML'), __('Default'), __('Sort Order'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($content_data AS $content)
{

	// Link to child view, link to the edit screen
	if ($content['ContentType']['name']=='category') {
		$name_link = $this->Html->link($this->Html->image('admin/icons/folder.png'), '/contents/admin/0/' . $content['Content']['id'], array('escape' => false));
	} else {
		$name_link = '';
	}
	
	if ($content['ContentType']['name']=='category') {
		$name_link .= $this->Html->link($content['ContentDescription']['name'], '/contents/admin/0/' . $content['Content']['id']);
	} else {
		$name_link .= $this->Html->link($content['ContentDescription']['name'], '/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
	}
	
	if ($content['ContentType']['name']=='product' || $content['ContentType']['name']=='downloadable') {
		$discounts = $this->Admin->ActionButton('discounts', '/discounts/admin/' . $content['ContentProduct']['id'],__('Discounts')); 
	} else {
		$discounts = null; 
	}
	
	echo $this->Admin->TableCells(
		array(
			$name_link,
			__($content['ContentType']['name']),
			array($this->Ajax->link(($content['Content']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_active_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Ajax->link(($content['Content']['show_in_menu'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_show_in_menu_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Ajax->link(($content['Content']['yml_export'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_yml_export_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Admin->DefaultButton($content['Content']), array('align'=>'center')),
			array($content['Content']['order'], array('align'=>'center')),
			array($this->Admin->ActionButton('edit','/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0),__('Edit')) . $this->Admin->ActionButton('delete','/contents/admin_delete/' . $content['Content']['id'],__('Delete')) . $discounts, array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $content['Content']['id'])), array('align'=>'center'))
		));
}

// Display a link letting the user to go up one level
if(isset($parent_content))
{
	$parent_link = $this->Admin->linkButton(__('Up One Level'),'/contents/admin/0/' . $parent_content['Content']['parent_id'],'cus-arrow-up',array('escape' => false, 'class' => 'btn'));
	echo '<tr><td colspan="9">' . $parent_link . '</td></tr>';	
}
echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'show_in_menu'=>__('Show In Menu'),'hide_from_menu'=>__('Hide From Menu'), 'yml_export' => __('Export to YML'), 'yml_not_export' => __('Not export to YML'), 'delete'=>__('Delete'),'copy'=>__('Copy'),'move'=>__('Move')),true,(isset($last_content_id) ? $last_content_id : 0).'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
echo $this->Form->end();
echo $this->Admin->ShowPageHeaderEnd();

?>