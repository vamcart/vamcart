<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/jquery.min.js',
	'jquery/plugins/jquery.validation.js',
	'jquery/plugins/ui.core.js',
	'jquery/plugins/ui.tabs.js',
	'tabs.js',
	'focus-first-input.js',
	'codemirror/lib/codemirror.js',
	'codemirror/mode/javascript/javascript.js',
	'codemirror/mode/css/css.js',
	'codemirror/mode/xml/xml.js',
	'codemirror/mode/htmlmixed/htmlmixed.js'
), array('inline' => false));

$html->css(array(
	'ui.tabs',
	'codemirror/codemirror',
	'codemirror/css',
	'codemirror/xml',
	'codemirror/javascript'
), null, array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'stylesheets.png');

	echo $form->create('Stylesheet', array('id' => 'contentform', 'action' => '/stylesheets/admin_edit/'.$data['Stylesheet']['id'], 'url' => '/stylesheets/admin_edit/'.$data['Stylesheet']['id']));

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true), 'main.png');
			echo $admin->CreateTab('options',__('Options',true), 'options.png');			
			echo '</ul>';

	echo $validation->bind('Stylesheet', array('form' => '#contentform', 'messageId' => 'messages'));
		
	echo $admin->StartTabContent('main');
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Stylesheet Details', true),
				   'Stylesheet.id' => array(
				   		'type' => 'hidden',
						'value' => $data['Stylesheet']['id']
	               ),
	               'Stylesheet.name' => array(
   				   		'label' => __('Name', true),				   
   						'value' => $data['Stylesheet']['name']
	               ),
				   'Stylesheet.stylesheet' => array(
   				   		'label' => __('Stylesheets', true),				   
   						'id' => 'code',
   						'value' => $data['Stylesheet']['stylesheet']
	               )																										
			));
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');			
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Stylesheet Details', true),
					'Stylesheet.alias' => array(
			   		'label' => __('Alias', true),				   
					'value' => $data['Stylesheet']['alias']
                	),
				   'Stylesheet.active' => array(
				   		'label' => __('Active', true),
				   		'type' => 'checkbox',
						'class' => 'checkbox_group',						
   						'checked' => $active_checked
	               )																										
			));
			
	echo $admin->EndTabContent();			

	echo $admin->EndTabs();

	echo '<div id="messages"></div>';
				
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Apply', true), array('name' => 'apply')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();

	echo $admin->ShowPageHeaderEnd();

	echo $html->scriptBlock('
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
  lineNumbers: true,
  onCursorActivity: function() {
    editor.setLineClass(hlLine, null);
    hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
  }
});
var hlLine = editor.setLineClass(0, "activeline");
', array('allowCache'=>false,'safe'=>false,'inline'=>true));	
	
?>