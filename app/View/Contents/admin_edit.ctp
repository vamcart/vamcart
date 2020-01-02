<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<?php

$l = $this->Session->read('Config.language');

if (NULL == $l) {
	$l = $this->Session->read('Customer.language');
}

$l = substr($l, 0, 2);

$fname = 'datepicker-' . $l . '.js';

if (!file_exists(WWW_ROOT . 'js/jquery/plugins/jquery-ui/' . $fname)) {
	$fname = 'datepicker-en.js';
}

$this->Html->script(array(
	'jquery/plugins/cookie/jquery.cookie.js',
	'jquery/plugins/ui/jquery-ui.min.js',
	'jquery/plugins/uploadfile/jquery.uploadfile.js',
	'jquery/plugins/jquery-ui/' . $fname,
	'jquery/plugins/dynatree/jquery.dynatree.js',
	'jquery/plugins/select2/select2.min.js',
	'admin/modified.js',
	'admin/focus-first-input.js'
), array('inline' => false));

$this->Html->css(
array(
'jquery/plugins/ui/jquery-ui.css',
'jquery/plugins/dynatree/ui.dynatree.css',
'jquery/plugins/select2/select2.css'
'jquery/plugins/select2/select2-bootstrap.css'
)
, null, array('inline' => false));
	
	echo $this->TinyMce->init();
?>
<?php echo $this->Html->scriptBlock('
	$(document).ready(function(){

		$("select#ContentContentTypeId").on("change",function () {
			$("div#content_type_fields").load("'. BASE . '/contents/admin_edit_type/"+$("select#ContentContentTypeId").val());
		})

		$(function() {
			$( "#date_start" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
			$( "#date_end" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		});

		$("#products-tree").dynatree({
			checkbox: true,
			selectMode: 3,
			initAjax: {
				url: "' . BASE . '/contents/admin_products_tree/0/' . (isset($data['Content']['id']) ? $data['Content']['id'] : 0) . '" ,
			},
			onLazyRead: function(node){
				node.appendAjax({
					url: "' . BASE . '/contents/admin_products_tree/" + node.data.key + "/" + node.data.products_id,
				});
			},
			onSelect: function(select, node) {

				if (select) {
					var selection = 1;
				} else {
					var selection = 0;
				}

				$.ajax({
					url: "' . BASE . '/contents/admin_set_relation/" + node.data.products_id + "/" + node.data.key + "/" + selection,
				});
			}
		});
	});
	
    $(document).ready(function() {
        $("#select2-parent").select2({
            theme: "bootstrap"
        });        
        $("#select2-brand").select2({
            theme: "bootstrap"
        });        
    });    
	
	
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');
?>
<?php
	
	// Set default div styling for template_requured container divs
	if((isset($data['ContentType']['template_type_id']) && $data['ContentType']['template_type_id'] > 0)||(empty($data)))
		$tpl_req_style = "block";
	else
		$tpl_req_style = "none";

	echo $this->Form->create('Content', array('id' => 'contentform', 'name' => 'contentform','enctype' => 'multipart/form-data', 'url' => '/contents/admin_edit/' . (isset($data['Content']['id']) ? $data['Content']['id'] : '')));
	
			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('data',__('Data'), 'cus-table-multiple');
			if (isset($data['Content']['content_type_id'])) if (($data['Content']['content_type_id'] == 2 or $data['Content']['content_type_id'] == 7)) echo $this->Admin->CreateTab('special',__('Special'), 'cus-tag-yellow');
			echo $this->Admin->CreateTab('view_images',__('View Images'), 'cus-pictures');
			echo $this->Admin->CreateTab('upload_images',__('Upload Images'), 'cus-picture-add');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');
			if (isset($data['Content']['id']) && ($data['Content']['content_type_id'] == 2 or $data['Content']['content_type_id'] == 7)) echo $this->Admin->CreateTab('relations', __('Cross-Sell'), 'cus-cart-put');
         //if (isset($data['Content']['id']) and ($data['Content']['content_type_id'] == 1 or $data['Content']['content_type_id'] == 2 or $data['Content']['content_type_id'] == 7)) 
         echo $this->Admin->CreateTab('atributes',__('Attributes'), 'cus-tag-green');
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
	echo $this->Admin->StartTabContent('main');
		echo $this->Form->input('Content.id', 
						array(
							'type' => 'hidden',
							'value' => isset($data['Content']['id']) ? $data['Content']['id'] : ''
	               ));
		echo $this->Form->input('Content.order', 
						array(
							'type' => 'hidden',
							'value' => isset($data['Content']['order']) ? $data['Content']['order'] : ''
	               ));

		echo $this->Form->input('Content.parent_id', 
					array(
						'type' => 'select',
			   		'label' => __('Parent'),
						'options' => $this->requestAction('/contents/admin_parents_tree/'),
						'id' => 'select2-parent',
						'escape' => false,
						'empty' => array(0 => __('Top Level')),
						'selected' => $parent_id
               ));
			
			echo '<ul id="myTabLang" class="nav nav-tabs">';
	foreach($languages AS $language)
	{
			echo $this->Admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],'cus-page-white');
	}
			echo '</ul>';

	echo $this->Admin->StartTabs('sub-tabs');
	
	// Loop through the languages and display a name and descrition for each
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];

	echo $this->Admin->StartTabContent('language_'.$language_key);
			
		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][name.' . $language['Language']['id'], 
						array(
				   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Title'),
							'value' => isset($data['ContentDescription'][$language_key]['name']) ? $data['ContentDescription'][$language_key]['name'] : ''
						));																								
	
		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required" style="display:' . $tpl_req_style . ';">';
			echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][description.' . $language['Language']['id'], 
						array(
				   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Description'),
				   		'type' => 'textarea',
				   		'class' => 'pagesmalltextarea',
				   		'id' => 'content_description_'.$language['Language']['id'],						
				   		'value' => isset($data['ContentDescription'][$language_key]['description']) ? $data['ContentDescription'][$language_key]['description'] : ''
						));
		echo '</div>';						  
		
		echo $this->TinyMce->toggleEditor('content_description_'.$language['Language']['id']);						  

		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required" style="display:' . $tpl_req_style . ';">';
			echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][short_description.' . $language['Language']['id'], 
						array(
				   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Short Description'),
				   		'type' => 'textarea',
				   		'class' => 'pagesmalltextarea',
				   		'id' => 'content_short_description_'.$language['Language']['id'],						
				   		'value' => isset($data['ContentDescription'][$language_key]['short_description']) ? $data['ContentDescription'][$language_key]['short_description'] : ''
						));
		echo '</div>';						  
		
		echo $this->TinyMce->toggleEditor('content_short_description_'.$language['Language']['id']);						  

		echo '<br />';						  
		
		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][meta_title.' . $language['Language']['id'], 
						array(
				   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Title'),
				   		'value' => isset($data['ContentDescription'][$language_key]['meta_title']) ? $data['ContentDescription'][$language_key]['meta_title'] : ''
						));																								

		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][meta_description.' . $language['Language']['id'], 
						array(
				   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Description'),
				   		'value' => isset($data['ContentDescription'][$language_key]['meta_description']) ? $data['ContentDescription'][$language_key]['meta_description'] : ''
						));																								

		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][meta_keywords.' . $language['Language']['id'], 
						array(
				   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Keywords'),
				   		'value' => isset($data['ContentDescription'][$language_key]['meta_keywords']) ? $data['ContentDescription'][$language_key]['meta_keywords'] : ''
						));																								

	echo $this->Admin->EndTabContent();
	}
		
	echo $this->Admin->EndTabs();
		
	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('data');

   		echo $this->Form->input('Content.content_type_id', 
   					array(
							'type' => 'select',
				   		'label' => __('Content Type'),
							'options' => $content_types,
							'selected' => (!isset($data['Content']['content_type_id'])? 2 : $data['Content']['content_type_id'])
	               ));

		echo '<div id="content_type_fields">';
			echo $this->requestAction( '/contents/admin_edit_type/' . (!isset($data['Content']['content_type_id'])? 2 : $data['Content']['content_type_id']) . '/' . (isset($data['Content']['id']) ? $data['Content']['id'] : '' ), array('return'));
		echo '</div>';
	
	echo '<div class="template_required" id="template_required_template_picker" style="display:' . $tpl_req_style . ';">';
	
		echo $this->Form->input('Content.template_id', 
						array(
							'type' => 'select',
							'label' => __('Template'),
							'options' => $templates,
							'selected' => isset($data['Content']['template_id']) ?$data['Content']['template_id'] : ''
						));
	echo '</div>';	

	echo $this->Admin->EndTabContent();            

	if (isset($data['Content']['content_type_id'])) {
	if (($data['Content']['content_type_id'] == 2 or $data['Content']['content_type_id'] == 7)) {	
	
	echo $this->Admin->StartTabContent('special');

	echo $this->Form->input('ContentSpecial.price', 
		array(
			'label' => __('Special Price'),
			'type' => 'text',
			'value' => !isset($data['ContentSpecial']['price'])? false : $data['ContentSpecial']['price']
		));
		
	echo __('<b>Specials Notes:</b><ul><li>You can enter a percentage to deduct in the Specials Price field, for example: <b>20%</b></li><li>If you enter a new price, the decimal separator must be a \'.\' (decimal-point), example: <b>49.99</b></li><li>Leave the start/end date empty for no expiration.</li></ul>');

	echo $this->Form->input('ContentSpecial.date_start', 
		array(
			'label' => __('Date Start'),
			'type' => 'text',
			'dateFormat' => 'Y-m-d H:i:s',
			'id' => 'date_start',
			'value' => !isset($data['ContentSpecial']['date_start'])? false : $data['ContentSpecial']['date_start']
		));

	echo $this->Form->input('ContentSpecial.date_end', 
		array(
			'label' => __('Date End'),
			'type' => 'text',
			'id' => 'date_end',
			'value' => !isset($data['ContentSpecial']['date_end'])? false : $data['ContentSpecial']['date_end']
		));

	echo $this->Admin->EndTabContent();
	
	}
	}

	echo $this->Admin->StartTabContent('view_images');
		echo '<div id="content_images_holder">';		
		echo $this->requestAction('/images/admin_view_content_images/' . (!isset($data['Content']['id'])? 0 : $data['Content']['id']), array('return'));	
		echo '</div>';
		
	echo $this->Admin->EndTabContent();


	echo $this->Admin->StartTabContent('upload_images');
	
		echo '<p>' . __('Press \'Upload Images\' and choose images from your computer to upload. Select as many files as you would like. Images will upload right after you select them.') . '</p>';
		echo '<div class="help tip"><p>' . __('TIP: Hold the \'control\' button to select more than one image.') . '</p></div>';		
		echo '<div class="help tip"><p>' . __('TIP: Also, you can Drag &amp; Drop Files to dotted zone.') . '</p></div>';		
		?>
<?php echo $this->Html->scriptBlock('
$(document).ready(function()
{
	$("#fileuploader").uploadFile({
	url:"' . BASE . '/contents/upload_images/' . $content_id . '",
	allowedTypes:"png,gif,jpg,jpeg",
	fileName:"myfile",
	showDone: false,
	showPreview: true,
	statusBarWidth: 250,
	dragDropStr: "",
	uploadButtonClass: "btn btn-default",
	showFileCounter: false,
	dragDropStr: "",
	abortStr: "'.__('Abort').'",
	cancelStr: "'.__('Cancel').'",
	deletelStr: "'.__('Delete').'",
	doneStr: "'.__('Done').'",
	multiDragErrorStr: "'.__('Multiple File Drag &amp; Drop is not allowed.').'",
	extErrorStr: "'.__('is not allowed. Allowed extensions: ').'",
	sizeErrorStr: "'.__('is not allowed. Allowed Max size: ').'",
	uploadErrorStr: "'.__('Upload is not allowed').'",
	maxFileCountErrorStr: "'.__(' is not allowed. Maximum allowed files are: ').'",
	downloadStr: "'.__('Download').'"	
	});
});
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
		

			<div id="fileuploader"><i class="cus-add"></i> <?php echo __('Upload Images'); ?></div>

		<?php
		
	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('options');
			echo $this->Form->input('Content.alias', 
					array(
			   		'label' => __('Alias'),				   
						'value' => isset($data['Content']['alias']) ? $data['Content']['alias'] : ''
					));
			echo $this->Form->input('Content.order', 
					array(
			   		'label' => __('Sort Order'),				   
						'value' => isset($data['Content']['order']) ? $data['Content']['order'] : '0'
					));
			//echo $this->Form->input('Content.head_data', 
					//array(
						//'label' => __('Head Data'),
						//'type' => 'textarea',
						//'class' => 'notinymce',
						//'value' => isset($data['Content']['head_data']) ? $data['Content']['head_data'] : ''
	            //));				
			echo $this->Form->input('Content.active', 
					array(
						'type' => 'checkbox',
			   		'label' => __('Active'),
						'value' => '1',
						'class' => 'checkbox_group',
						'checked' => isset($data['Content']['active']) ? $data['Content']['active'] : '1'
					));
			echo $this->Form->input('Content.show_in_menu', 
					array(
						'type' => 'checkbox',
			   		'label' => __('Show in menu'),
						'value' => '1',
						'class' => 'checkbox_group',
						'checked' => isset($data['Content']['show_in_menu']) ? $data['Content']['show_in_menu'] : '1'
					));
	echo $this->Admin->EndTabContent();

	if (isset($data['Content']['id']) && ($data['Content']['content_type_id'] == 2 or $data['Content']['content_type_id'] == 7)) {
	echo $this->Admin->StartTabContent('relations');
	echo '<div id="products-tree" name="relations"></div>';
	echo $this->Admin->EndTabContent();
	}

        if (isset($data['Content']['id']) and ($data['Content']['content_type_id'] == 1 or $data['Content']['content_type_id'] == 2 or $data['Content']['content_type_id'] == 7)) {
            echo $this->Admin->StartTabContent('atributes');                            
                if ($data['Content']['content_type_id'] == 2) { 
                    echo '<br />';
                    echo $this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Attributes'),'class' => 'cus-tag-green')) . ' ' . __('Set attributes values'), '/attributes/admin_editor_value_dialog/edit/' . $data['Content']['id'], array('escape' => false, 'update' => '#dialog_attr','class' => 'btn btn-default'));
                    echo '<br /><br />';
                    echo $this->Js->writeBuffer();  
                    echo '<div id="dialog_attr">';
                } else if($data['Content']['content_type_id'] == 1) {               
                    echo '<div id="dialog_add_attr"></div>';
                    echo '<div id="view_attr">';
                        echo $this->requestAction('/attributes/admin_viewer_attr_dialog/' . $data['Content']['id'], array('return'));	
                    echo '</div>';
                }
            echo $this->Admin->EndTabContent();        
        } else {
         echo $this->Admin->StartTabContent('atributes');                            
			echo '<div class="alert alert-info"><i class="fa fa-lightbulb-o"></i> ' . __('Attributes manager available for categories and products content types.') . '</div>';
			if (!isset($data['Content']['id']) and ($data['Content']['content_type_id'] != 1 or $data['Content']['content_type_id'] != 2 or $data['Content']['content_type_id'] != 7)) echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> ' . __('Please save your data (click Apply button) and attributes manager will be available.') . '</div>';
         echo $this->Admin->EndTabContent();        
        }
        
        
	echo $this->Admin->EndTabs();

	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submitbutton')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>