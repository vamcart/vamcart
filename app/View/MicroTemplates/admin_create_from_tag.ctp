<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/modified.js',
	'admin/focus-first-input.js',
	'codemirror/lib/codemirror.js',
	'codemirror/mode/javascript/javascript.js',
	'codemirror/mode/css/css.js',
	'codemirror/mode/xml/xml.js',
	'codemirror/mode/htmlmixed/htmlmixed.js'
), array('inline' => false));

$this->Html->css(array(
	'codemirror/codemirror',
), null, array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-add');

	echo $this->Form->create('MicroTemplate', array('id' => 'contentform', 'url' => '/micro_templates/admin_edit/'));
		
		echo $this->Form->input('MicroTemplate.id', 
							array(
   				   		'type' => 'hidden'
							));  
		echo $this->Form->input('MicroTemplate.alias', 
							array(
   				   		'label' => __('Alias')
							));
		echo $this->Form->input('MicroTemplate.tag_name', 
							array(
   				   		'label' => __('Tag Name')
							));
		echo $this->Form->input('MicroTemplate.template', 
							array(
							'type' => 'textarea',
							'id' => 'code',
					   	'label' => __('Template'),
							'value' => isset($default_template) ? $default_template : null,
							'onfocus' => 'this.select();'
	                	));

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