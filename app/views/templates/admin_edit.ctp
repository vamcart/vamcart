<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js',
	'codemirror/lib/codemirror.js',
	'codemirror/mode/javascript/javascript.js',
	'codemirror/mode/css/css.js',
	'codemirror/mode/xml/xml.js',
	'codemirror/mode/htmlmixed/htmlmixed.js'
), array('inline' => false));

$html->css(array(
	'codemirror/codemirror',
	'codemirror/css',
	'codemirror/xml',
	'codemirror/javascript'
), null, array('inline' => false));

	$template_id = $this->data['Template']['id'];

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_edit/'.$template_id, 'url' => '/templates/admin_edit/'.$template_id));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Template Details', true),
				   'Template.id' => array(
				   		'type' => 'hidden'
	               ),
				   'Template.template' => array(
   				   		'id' => 'code',
   				   		'label' => __('Template', true)
	               )																										
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit')) . $admin->formButton(__('Apply', true), 'apply.png', array('type' => 'submit', 'name' => 'apply')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 

	echo $html->scriptBlock('
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
  mode: "text/html",
  lineNumbers: true,
  onCursorActivity: function() {
    editor.setLineClass(hlLine, null);
    hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
  }
});
var hlLine = editor.setLineClass(0, "activeline");
', array('allowCache'=>false,'safe'=>false,'inline'=>true));	
	
?>