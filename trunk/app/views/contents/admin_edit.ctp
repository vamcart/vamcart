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
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main', true));
			echo $admin->CreateTab('view_images',__('View Images', true));	
			echo $admin->CreateTab('upload_images',__('Upload Images', true));			
			echo $admin->CreateTab('options',__('Options', true));			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
				'fieldset' => __('Categories & Products',true),
				'Content/id' => array(
					'type' => 'hidden',
					'value' => $data['Content']['id']
	               ),
				'Content/order' => array(
					'type' => 'hidden',
					'value' => $data['Content']['order']
	               )
				   ));
	$parent_language_bug_fix = __('Parent', true);
	
	echo '<div class="input"><label>' . $parent_language_bug_fix . '</label>' . $form->select('Content/parent_id', $parents, $data['Content']['parent_id'], $attributes = array('label' => $parent_language_bug_fix), $showEmpty = __('Top Level', true)) . '</div>';

   		echo $form->inputs(array(
   					'Content/content_type_id' => array(
						'type' => 'select',
				   	'label' => __('Content Type', true),
						'options' => $content_types,
						'selected' => (!isset($data['Content']['content_type_id'])? 2 : $data['Content']['content_type_id']),
						'onchange' => 'change_content_type();'
	               )));

		echo '<div id="content_type_fields">';
			echo $this->requestAction( '/contents/admin_edit_type/' . $data['Content']['content_type_id'] . '/' . $data['Content']['id'], array('return'=>true));	
		echo '</div>';
	
	echo '<div class="template_required" id="template_required_template_picker" style="display:' . $tpl_req_style . ';">';
	
	  	echo $form->inputs(array('Content/template_id' => array(
						'type' => 'select',
				   	'label' => __('Template', true),
						'options' => $templates,
						'selected' => $data['Content']['template_id']
	            	  )));
	echo '</div>';	
	
	// Loop through the languages and display a name and descrition for each
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][name/' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('Title (%s) ', true),__($language['Language']['name'], true)),
						'value' => $data['ContentDescription'][$language_key]['name']
	            	  )));																								
	
		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required" style="display:' . $tpl_req_style . ';">';
			echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][description/' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('Description (%s) ', true),__($language['Language']['name'], true)),
						'type' => 'textarea',
						'class' => 'pagesmalltextarea',						
						'value' => $data['ContentDescription'][$language_key]['description']
	            	  )));
		echo '</div>';						  
	}
		
		
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('view_images');
		echo '<div id="content_images_holder">';		
		echo $this->requestAction('/images/admin_view_content_images/' . $data['Content']['id'], array('return'=>true));	
		echo '</div>';
		
	echo $admin->EndTabContent();


	echo $admin->StartTabContent('upload_images');
	
	if((isset($data['Content']['id'])) && ($data['Content']['id'] > 0))
	{
		echo '<p>' . __('Press \'Upload Images\' and choose images from your computer to upload. Select as many files as you would like. Images will upload right after you select them.', true) . '</p>';
		echo '<div class="help tip"><p>' . __('TIP: Hold the \'control\' button to select more than one image.', true) . '</p></div>';		
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
				browse_link_innerhtml : "<?php __('Browse Images') ?>",
				upload_link_innerhtml : "<?php __('Upload Images') ?>",
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
		<div class="clear"></div>
		<h4 id="queueinfo"></h4>		
		<div id="SWFUploadTarget"></div>		
		<?php
	
	}
	else
	{
		echo '<p>' . __('This is a new product. Please press apply before uploading images.', true)	 . '</p>';
	}
			
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
			echo $form->inputs(array(
				'fieldset' => __('content_details', true),
                'Content/alias' => array(
			   		'label' => __('Alias', true),				   
					'value' => $data['Content']['alias']
                ),
				'Content/head_data' => array(
					'label' => __('Head Data', true),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',
					'value' => $data['Content']['head_data']
	             ),				
			    'Content/active' => array(
					'type' => 'checkbox',
			   		'label' => __('Active', true),
					'value' => '1',
					'class' => 'checkbox_group',
					'checked' => $active_checked
                ),
			    'Content/show_in_menu' => array(
					'type' => 'checkbox',
			   		'label' => __('Show in menu', true),
					'value' => '1',
					'class' => 'checkbox_group',
					'checked' => $menu_checked
                )
		));
	echo $admin->EndTabContent();

	echo $admin->EndTabs();
	
	echo $form->submit( __('Submit', true), array('name' => 'submitbutton', 'id' => 'submitbutton')) . $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>