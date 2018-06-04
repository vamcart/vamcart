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
	'jquery/plugins/jeditable/jquery.jeditable.js',
	'jquery/plugins/chosen/chosen.jquery.js',
	'admin/selectall.js',
	'admin/'.$fname
), array('inline' => false));
?>

<div id="dialog_attr"></div>

<?php echo $this->Html->scriptBlock('

    $(document).ready(function() {
        $("#chosen-select").chosen({
            no_results_text:"'. __("Not Found") .'",
            search_contains:true,
            placeholder_text_single:"'. __("Select") .'",
            width: "300px"
        });        
    });    
	
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

$this->Html->css(
array(
'jquery/plugins/ui/jquery-ui.css',
'jquery/plugins/chosen/bootstrap-chosen.css'
)
, null, array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');

echo '<table class="contentHeader">';
echo '<tr><td>';
echo '<div class="text-left">';
echo $this->Form->create('ContentCategories', array('url' => '/contents/admin/0/', 'type' => 'post'));
echo $this->Form->input('content_id', 
			array(
				'type' => 'select',
	   		'id' => 'chosen-select',
	   		'label' => false,
				'options' => $this->requestAction('/contents/admin_parents_tree/'),
				'escape' => false,
				'onchange' => "this.form.submit()",
				'empty' => array(0 => __('All Categories')),
				'selected' => $parent_id
         ));
echo $this->Form->end();
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';

echo $this->Form->create('Content', array('url' => '/contents/admin_modify_selected/', 'onsubmit' => 'return beforeSubmit(this);'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(__('Title'), __('Type'), __('Active'), __('Show in menu'), __('Export to YML'), __('Default'), __('Price'), __('Stock'), __('Sort Order'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($content_data AS $content)
{
	
								// Content Image
								
								if($content['ContentImage']['image'] != "") {
									$image_url = $content['Content']['id'] . '/' . $content['ContentImage']['image'] . '/40';
									$thumb_name = substr_replace($content['ContentImage']['image'] , '', strrpos($content['ContentImage']['image'] , '.')).'-40.png';	
									$thumb_path = IMAGES . 'content' . '/' . $content['Content']['id'] . '/' . $thumb_name;
									$thumb_url = BASE . '/img/content/' . $thumb_name;
					
										if(file_exists($thumb_path) && is_file($thumb_path)) {
											list($width, $height, $type, $attr) = getimagesize($thumb_path);
											$image =  $thumb_url;
											$image_width = $width;
											$image_height = $height;
										} else {
											$image = BASE . '/images/thumb/' . $image_url;
											$image_width = null;
											$image_height = null;
										}
					
								} else { 
					
									$image_url = 'noimage.png/40';
									$thumb_name = 'noimage-40.png';	
									$thumb_path = IMAGES . 'content/' . $thumb_name;
									$thumb_url = BASE . '/img/content/' . $thumb_name;
					
										if(file_exists($thumb_path) && is_file($thumb_path)) {
											list($width, $height, $type, $attr) = getimagesize($thumb_path);
											$image =  $thumb_url;
											$image_width = $width;
											$image_height = $height;
										} else {
											$image = BASE . '/images/thumb/' . $image_url;
											$image_width = null;
											$image_height = null;
										}
					
								}	
	
	// Link to child view, link to the edit screen
	if ($content['ContentType']['name']=='category') {
		$name_link = $this->Html->link($this->Html->image('admin/icons/folder.png'), '/contents/admin/0/' . $content['Content']['id'], array('escape' => false));
	} elseif ($content['Content']['content_type_id'] == 2 or $content['Content']['content_type_id'] == 7) {
		$name_link = $this->Html->image($image, array('alt' => __('True'),'width' => $image_width,'height' => $image_height)).'&nbsp;';
	} else {
		$name_link = '';
	}

	if ($content['Content']['content_type_id'] == 7) {
		$price = $content['ContentDownloadable']['price'];
		$stock = $content['ContentDownloadable']['stock'];
	} else {
		$price = $content['ContentProduct']['price'];
		$stock = $content['ContentProduct']['stock'];
	}
			
	if ($content['ContentType']['name']=='category') {
		$name_link .= $this->Html->link($content['ContentDescription']['name'], '/contents/admin/0/' . $content['Content']['id']);
	} else {
		$name_link .= $this->Html->link($content['ContentDescription']['name'], '/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
	}
	
	if ($content['ContentType']['name']=='product' || $content['ContentType']['name']=='downloadable') {
		$add_action_btn = $this->Admin->ActionButton('discounts', '/discounts/admin/' . $content['ContentProduct']['id'],__('Discounts'))
                                . $this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Attributes'),'class' => 'cus-tag-green')), '/attributes/admin_editor_value_dialog/edit/' . $content['Content']['id'], array('escape' => false, 'update' => '#dialog_attr'));
                echo $this->Js->writeBuffer();        
	} else {
		$add_action_btn = null; 
	}
	
	echo $this->Admin->TableCells(
		array(
			$name_link,
			__($content['ContentType']['name']),
			array($this->Ajax->link(($content['Content']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_active_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Ajax->link(($content['Content']['show_in_menu'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_show_in_menu_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Ajax->link(($content['Content']['yml_export'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_yml_export_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Admin->DefaultButton($content['Content']), array('align'=>'center')),
			($content['Content']['content_type_id'] == 2 or $content['Content']['content_type_id'] == 7) ? array($price,array('id' => $content['Content']['id'],'align' => 'center', 'class' => 'edit'))	: false,
			($content['Content']['content_type_id'] == 2 or $content['Content']['content_type_id'] == 7) ? array($stock,array('id' => 'stock'.$content['Content']['id'],'align' => 'center', 'class' => 'edit'))	: false,
			array($content['Content']['order'], array('align'=>'center')),
			array($this->Admin->ActionButton('edit','/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0),__('Edit')) 
                            . $this->Admin->ActionButton('delete','/contents/admin_delete/' . $content['Content']['id'],__('Delete')) 
                            . $add_action_btn, array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $content['Content']['id'])), array('align'=>'center'))
		));

		// Ajax price change
		if ($content['Content']['content_type_id'] == 2 or $content['Content']['content_type_id'] == 7) {
		echo $this->Ajax->editor($content['Content']['id'],'/contents/admin_change_price/',  array('width' => 60, 'tooltip' => $content['Content']['id'],'placeholder' => '_','onblur' => 'submit'));					
		}

		// Ajax stock change
		if ($content['Content']['content_type_id'] == 2 or $content['Content']['content_type_id'] == 7) {
		echo $this->Ajax->editor('stock'.$content['Content']['id'],'/contents/admin_change_stock/'.$content['Content']['id'],  array('width' => 40, 'tooltip' => $content['Content']['id'],'placeholder' => '_','onblur' => 'submit'));					
		}

}

// Display a link letting the user to go up one level
if(isset($parent_content))
{
	$parent_link = $this->Admin->linkButton(__('Up One Level'),'/contents/admin/0/' . $parent_content['Content']['parent_id'],'cus-arrow-up',array('escape' => false, 'class' => 'btn btn-default'));
	echo '<tr><td colspan="11">' . $parent_link . '</td></tr>';	
}
echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'show_in_menu'=>__('Show In Menu'),'hide_from_menu'=>__('Hide From Menu'), 'yml_export' => __('Export to YML'), 'yml_not_export' => __('Not export to YML'), 'delete'=>__('Delete'),'copy'=>__('Copy'),'move'=>__('Move')),true,(isset($last_content_id) ? $last_content_id : 0).'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
echo $this->Form->end();
?>

<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>

<?php
echo $this->Admin->ShowPageHeaderEnd();

?>