<?php
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

	echo $this->Form->create('AttributeTemplate', array('id' => 'contentform', 'action' => '/admin_edit/save/'));		
	echo $this->Form->input('AttributeTemplate.id',array('type' => 'hidden'));  
        
        
        echo '<ul id="myTab" class="nav nav-tabs">';
        echo $this->Admin->CreateTab('templates',__('Templates'),'cus-application-edit');
        echo $this->Admin->CreateTab('settings',__('Settings'),'cus-wrench');
        echo '</ul>';
               
        echo $this->Admin->StartTabs('sub-tabs');
        echo $this->Admin->StartTabContent('templates');
        
            echo $this->Form->input('AttributeTemplate.name',array('label' => __('Name')));

            /*echo '<ul id="myTabLang" class="nav nav-tabs">';
            echo $this->Admin->CreateTab('template_filter',__('Template to filter'),'cus-application-edit');
            echo $this->Admin->CreateTab('template_editor',__('Template to editor'),'cus-application-edit');
            echo $this->Admin->CreateTab('template_catalog',__('Template to catalog'),'cus-application-edit');
            echo $this->Admin->CreateTab('template_cart',__('Template to product'),'cus-application-edit');
            echo $this->Admin->CreateTab('template_cart',__('Template to compare'),'cus-application-edit');
            echo '</ul>';*/

            //echo $this->Admin->StartTabs('sub-tabs');

            //echo $this->Admin->StartTabContent('template_filter');
            echo $this->Form->input('AttributeTemplate.template_filter', 
                                            array('type' => 'textarea',
                                                    'id' => 'code_template_filter',
                                                 'label' => __('Template to filter')
                                    ));
            //echo $this->Admin->EndTabContent();

            //echo $this->Admin->StartTabContent('template_editor');
            echo $this->Form->input('AttributeTemplate.template_editor', 
                                            array('type' => 'textarea',
                                                    'id' => 'code_template_editor',
                                                 'label' => __('Template to editor')
                                    ));
            //echo $this->Admin->EndTabContent();

            //echo $this->Admin->StartTabContent('template_catalog');
            echo $this->Form->input('AttributeTemplate.template_catalog', 
                                            array('type' => 'textarea',
                                                    'id' => 'code_template_catalog',
                                                 'label' => __('Template to catalog')
                                    ));
            //echo $this->Admin->EndTabContent();

            //echo $this->Admin->StartTabContent('template_product');
            echo $this->Form->input('AttributeTemplate.template_product', 
                                            array('type' => 'textarea',
                                                    'id' => 'code_template_product',
                                                 'label' => __('Template to product')
                                    ));
            //echo $this->Admin->EndTabContent();

            //echo $this->Admin->StartTabContent('template_compare');
            echo $this->Form->input('AttributeTemplate.template_compare', 
                                            array('type' => 'textarea',
                                                    'id' => 'code_template_compare',
                                                 'label' => __('Template to compare')
                                    ));
            //echo $this->Admin->EndTabContent();

            //echo $this->Admin->EndTabs();

            echo $this->Admin->EndTabContent();
        
        echo $this->Admin->StartTabContent('settings');
            echo $this->Form->input('DefaulValue.dig_value',array('label' => 'Default value -> (dig_value)' ,'type' => 'checkbox'));
            echo $this->Form->input('DefaulValue.max_value',array('label' => 'Default value -> (max_value)' ,'type' => 'checkbox'));
            echo $this->Form->input('DefaulValue.min_value',array('label' => 'Default value -> (min_value)' ,'type' => 'checkbox'));
            echo $this->Form->input('DefaulValue.like_value',array('label' => 'Default value - >(like_value)' ,'type' => 'checkbox'));            
            echo $this->Form->input('DefaulValue.list_value',array('label' => 'Default value - >(list_value)' ,'type' => 'checkbox'));            
            echo $this->Form->input('DefaulValue.checked_list',array('label' => 'Default value - >(checked_list)' ,'type' => 'checkbox'));            
            echo $this->Form->input('DefaulValue.any_value',array('label' => 'Default value - >(any_value)' ,'type' => 'checkbox'));            
        echo $this->Admin->EndTabContent();
        echo $this->Admin->EndTabs();
        
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn', 'type' => 'submit', 'name' => 'apply')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
	
	echo $this->Html->scriptBlock('
        CodeMirror.fromTextArea(document.getElementById("code_template_filter"), {
          mode: "text/html",
          lineNumbers: true,
          lineWrapping: true
        });
        CodeMirror.fromTextArea(document.getElementById("code_template_editor"), {
          mode: "text/html",
          lineNumbers: true,
          lineWrapping: true
        });
        CodeMirror.fromTextArea(document.getElementById("code_template_catalog"), {
          mode: "text/html",
          lineNumbers: true,
          lineWrapping: true
        });
        CodeMirror.fromTextArea(document.getElementById("code_template_product"), {
          mode: "text/html",
          lineNumbers: true,
          lineWrapping: true
        });
        CodeMirror.fromTextArea(document.getElementById("code_template_compare"), {
          mode: "text/html",
          lineNumbers: true,
          lineWrapping: true
        });
        ', array('allowCache'=>false,'safe'=>false,'inline'=>true));	
	
?>