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
	'focus-first-input.js',
	'codemirror/codemirror.js'
), array('inline' => false));

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
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Apply', true), array('name' => 'apply')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 

	echo $html->scriptBlock('
      var editor = CodeMirror.fromTextArea("code", {
        height: "350px",
        parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
                     "tokenizephp.js", "parsephp.js",
                     "parsephphtmlmixed.js"],
        stylesheet: ["'. BASE . '/js/codemirror/css/xmlcolors.css", "'. BASE . '/js/codemirror/css/jscolors.css", "'. BASE . '/js/codemirror/css/csscolors.css", "'. BASE . '/js/codemirror/css/phpcolors.css"],
        path: "'. BASE . '/js/codemirror/",
        continuousScanning: 500
      });
', array('allowCache'=>false,'safe'=>false,'inline'=>true));	
	
?>