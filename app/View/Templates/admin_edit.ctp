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

	$template_id = $this->data['Template']['id'];

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

	echo $this->Form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_edit/'.$template_id, 'url' => '/templates/admin_edit/'.$template_id));
	echo $this->Form->input('Template.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('Template.template', 
						array(
   				   	'id' => 'code',
   				   	'label' => __('Template')
	               ));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn', 'type' => 'submit', 'name' => 'apply')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 

	echo $this->Html->scriptBlock('
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
  mode: "text/html",
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