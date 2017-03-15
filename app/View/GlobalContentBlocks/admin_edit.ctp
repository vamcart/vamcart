<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js',
	'codemirror/lib/codemirror.js',
	'codemirror/mode/javascript/javascript.js',
	'codemirror/mode/css/css.js',
	'codemirror/mode/xml/xml.js',
	'codemirror/mode/htmlmixed/htmlmixed.js'
), array('inline' => false));

$this->Html->css(array(
	'codemirror/codemirror',
), null, array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

	$id = $this->data['GlobalContentBlock']['id'];
	echo $this->Form->create('GlobalContentBlock', array('id' => 'contentform', 'url' => '/global_content_blocks/admin_edit/'.$id));
	
			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');			
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
	echo $this->Admin->StartTabContent('main');
		echo $this->Form->input('GlobalContentBlock.id', 
						array(
				   		'type' => 'hidden'
	               ));
		echo $this->Form->input('GlobalContentBlock.name', 
						array(
   				   	'label' => __('Name')
	               ));
		echo $this->Form->input('GlobalContentBlock.content', 
						array(
							'type' => 'textarea',
  				   		'id' => 'code',
  				   		'label' => __('Contents')
                	));
	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('options');
		echo $this->Form->input('GlobalContentBlock.alias', 
						array(
   				   	'label' => __('Alias')
						));
		echo $this->Form->input('GlobalContentBlock.active', 
						array(
							'type' => 'checkbox',
   				   	'label' => __('Active'),
							'value' => '1',
							'class' => 'checkbox_group'
	                ));
	                
	echo $this->Admin->EndTabContent();
	
	echo $this->Admin->EndTabs();
	
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'apply')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
	
	echo $this->Html->scriptBlock('
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
  mode: "text/html",
  viewportMargin: Infinity,
  lineNumbers: true,
  lineWrapping: true
});
var hlLine = editor.addLineClass(0, "background", "activeline");
editor.on("cursorActivity", function() {
  var cur = editor.getLineHandle(editor.getCursor().line);
  if (cur != hlLine) {
    editor.removeLineClass(hlLine, "background", "activeline");
    hlLine = editor.addLineClass(cur, "background", "activeline");
  }
});
', array('allowCache'=>false,'safe'=>false,'inline'=>true));	
	
?>