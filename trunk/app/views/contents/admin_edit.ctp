<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/
//pr($data);
?>
<script language="javascript" type="text/javascript">
	function show_required_template_divs ()
	{
		// Hide all sections
		var sections = document.getElementsByClassName('template_required');
		for(var j=0; j<sections.length; j++)
		{
			$(sections[j].id).style.display = 'block';
		}
	}

	function hide_required_template_divs ()
	{
		// Hide all sections
		var sections = document.getElementsByClassName('template_required');
		for(var j=0; j<sections.length; j++)
		{
			$(sections[j].id).style.display = 'none';
		}
	}	

	function change_content_type ()
	{
		var select_box = $('ContentContentTypeId');
		var content_type_id = select_box.options[select_box.selectedIndex].value;
		
		new Ajax.Updater('content_type_fields', '/contents/admin_edit_type/' + content_type_id + '/<?php echo $data['Content']['id']; ?>', {asynchronous:true});
		
		// TODO: make this better
		if(content_type_id > 3)
		{
			 hide_required_template_divs();
		}
		else
		{
			show_required_template_divs();
		}
	}
	
	function update_content_images ()
	{
		// This isn't working for some reason.
		//new Ajax.Updater('content_images_holder', '/images/admin_view_content_images/<?php echo $data['Content']['id']; ?>', {asynchronous:false});
	}

</script>

<?php
	
	// Set default div styling for template_requured container divs
	if(($data['ContentType']['template_type_id'] > 0)||(empty($data)))
		$tpl_req_style = "block";
	else
		$tpl_req_style = "none";

	echo $form->create('Content', array('id' => 'contentform', 'name' => 'contentform','enctype' => 'multipart/form-data', 'action' => '/contents/admin_edit/'.$data['Content']['id'], 'url' => '/contents/admin_edit/'.$data['Content']['id']));
	
	echo $admin->StartTabs();
			echo $admin->CreateTab('main');
			echo $admin->CreateTab('view_images');	
			echo $admin->CreateTab('upload_images');			
			echo $admin->CreateTab('options');			
	echo $admin->EndTabs();
	
	echo $admin->StartTabContent('main');
		echo '<fieldset>';
		echo $form->inputs(array(
				'fieldset' => 'adfsdf',
				'Content/id' => array(
					'type' => 'hidden',
					'value' => $data['Content']['id']
	               ),
				'Content/order' => array(
					'type' => 'hidden',
					'value' => $data['Content']['order']
	               )
				   ));
	$parent_language_bug_fix = __('parent', true);
	
	echo '<div class="input"><label>' . $parent_language_bug_fix . '</label>' . $form->select('Content/parent_id', $parents, $data['Content']['parent_id'], $attributes = array('label' => $parent_language_bug_fix), $showEmpty = 'Top Level') . '</div>';

   		echo $form->inputs(array('Content/content_type_id' => array(
				   		'label' => __('content_type', true),
						'type' => 'select',
						'options' => $content_types,
						'selected' => (!isset($data['Content']['content_type_id'])? 2 : $data['Content']['content_type_id']),
						'onchange' => 'change_content_type();'
	               )));

		echo '<hr class="form_divider" />';
	
		echo '<div id="content_type_fields">';
			echo $this->requestAction( '/contents/admin_edit_type/' . $data['Content']['content_type_id'] . '/' . $data['Content']['id'], array('return'=>true));	
		echo '</div>';
	
		echo '<hr class="form_divider" />';
	
	echo '<div class="template_required" id="template_required_template_picker" style="display:' . $tpl_req_style . ';">';
	
	  	echo $form->inputs(array('Content/template_id' => array(
						'type' => 'select',
				   		'label' => __('layout_theme', true),
						'options' => $templates,
						'selected' => $data['Content']['template_id']
	            	  )));
	echo '</div>';	
	
	// Loop through the languages and display a name and descrition for each
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][name/' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('% title', true),__($language['Language']['name'], true)),
						'value' => $data['ContentDescription'][$language_key]['name']
	            	  )));																								
	
		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required" style="display:' . $tpl_req_style . ';">';
			echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][description/' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('% description', true),__($language['Language']['name'], true)),
						'type' => 'textarea',
						'class' => 'pagesmalltextarea',						
						'value' => $data['ContentDescription'][$language_key]['description']
	            	  )));
		echo '</div>';						  
	}
		
		
	echo '</fieldset>';
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('view_images');
	echo '<fieldset>';

		echo '<div id="content_images_holder">';		
		echo $this->requestAction('/images/admin_view_content_images/' . $data['Content']['id'], array('return'=>true));	
		echo '</div>';
		
	echo '</fieldset>';
	echo $admin->EndTabContent();


	echo $admin->StartTabContent('upload_images');
	echo '<fieldset>';
	
	if((isset($data['Content']['id'])) && ($data['Content']['id'] > 0))
	{
		echo '<p>' . __('content_upload_images', true) . '</p>';
		echo '<div class="help tip"><p>' . __('content_upload_images_tip', true) . '</p></div>';		
		?>
		<script type="text/javascript" language="javascript" src="/js/swfupload/SWFUpload.js"></script>
		<script type="text/javascript" language="javascript" src="/js/swfupload/callbacks.js"></script>
	
		<script language="javascript" type="text/javascript">
			var swfu;

			window.onload = function() {

				swfu = new SWFUpload({
				upload_script : "/contents/admin_upload_images/<?php echo $data['Content']['id']; ?>",
				target : "SWFUploadTarget",
				flash_path : "/js/swfupload/SWFUpload.swf?session_name()=<?php echo session_id(); ?>&"+Math.random(),
				allowed_filesize : 3072,	// 30 MB
				allowed_filetypes : "*.*",
				allowed_filetypes_description : "All files...",
				browse_link_innerhtml : "<?php __('browse_images') ?>",
				upload_link_innerhtml : "<?php __('upload_images') ?>",
				browse_link_class : "swfuploadbtn browsebtn",
				upload_link_class : "swfuploadbtn uploadbtn",
				flash_loaded_callback : 'swfu.flashLoaded',
				upload_file_queued_callback : "fileQueued",
				upload_file_start_callback : 'uploadFileStart',
				upload_progress_callback : 'uploadProgress',
				upload_file_complete_callback : 'uploadFileComplete',
				upload_file_cancel_callback : 'uploadFileCancelled',
				upload_queue_complete_callback : 'uploadQueueComplete',
				upload_error_callback : 'uploadError',
				upload_cancel_callback : 'uploadCancel',
				auto_upload : true			
				});
				hide_tabs();
			};	
		</script>
		
		<div id="SWFUploadFileListingFiles"></div>
		<div style="clear:both;"></div>
		<h4 id="queueinfo"></h4>		
		<div id="SWFUploadTarget"></div>		
		<?php
	
	}
	else
	{
		echo '<p>' . __('new_content_no_image', true)	 . '</p>';
	}
			
	echo '</fieldset>';
		
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
			echo $form->inputs(array(
				'fieldset' => __('content_details', true),
                'Content/alias' => array(
			   		'label' => __('alias', true),				   
					'value' => $data['Content']['alias']
                ),
				'Content/head_data' => array(
					'label' => __('content_head_data', true),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',
					'value' => $data['Content']['head_data']
	             ),				
			    'Content/active' => array(
					'type' => 'checkbox',
			   		'label' => __('active', true),
					'value' => '1',
					'class' => 'checkbox_group',
					'checked' => $active_checked
                ),
			    'Content/show_in_menu' => array(
					'type' => 'checkbox',
			   		'label' => __('show_in_menu', true),
					'value' => '1',
					'class' => 'checkbox_group',
					'checked' => $menu_checked
                )
		));
	echo $admin->EndTabContent();
	
	echo $form->submit( __('form_submit', true), array('name' => 'submitbutton', 'id' => 'submitbutton')) . $form->submit( __('form_apply', true), array('name' => 'applybutton')) . $form->submit( __('form_cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>