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

	$id = $this->data['MicroTemplate']['id'];

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('MicroTemplate', array('id' => 'contentform', 'action' => '/micro_templates/admin_edit/'.$id, 'url' => '/micro_templates/admin_edit/'.$id));
		
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Micro Template Details', true),
					'MicroTemplate.id' => array(
   				   		'type' => 'hidden'
	                ),  
					'MicroTemplate.alias' => array(
   				   		'label' => __('Alias', true)
	                ),
	                'MicroTemplate.tag_name' => array(
   				   		'label' => __('Tag Name', true)
	                ),
					'MicroTemplate.template' => array(
						'type' => 'textarea',
   				   		'id' => 'code',
   				   		'label' => __('Template', true)
	                ),
				));

	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Apply', true), 'apply.png', array('type' => 'submit', 'name' => 'apply')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
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