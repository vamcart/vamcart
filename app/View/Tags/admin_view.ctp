<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

if(isset($default_template))
{
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
}

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');

echo $help_content;

echo $about_content;

if(isset($default_template))
{
	echo '<div class="pageheader">' . __('Default Template') . '</div>';
	
		echo $this->Form->create('MicroTemplate', array('id' => 'contentform', 'action' => '/micro_templates/admin_create_from_tag/', 'url' => '/micro_templates/admin_create_from_tag/'));
		
		echo $this->Form->input('MicroTemplate.tag_name', 
					array(
						'value' => $tag_name,
						'type' => 'hidden'
					));
		echo $this->Form->input('MicroTemplate.tag_type', 
					array(
						'value' => $tag_type,
						'type' => 'hidden'
					));
		echo $this->Form->input('MicroTemplate.template', 
					array(
						'type' => 'textarea',
						'id' => 'code',
				   	'label' => __('Template'),
						'value' => $default_template,
						'onfocus' => 'this.select();'
					));

	echo $this->Admin->formButton(__('Create Micro Template From Tag'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
}

echo $this->Admin->ShowPageHeaderEnd();

if(isset($default_template))
{
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
}

?>