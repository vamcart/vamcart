<?php
$this->Html->script(array(
	'selectall.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-database-refresh');

echo '<ul id="myTab" class="nav nav-tabs">';
echo $this->Admin->CreateTab('import',__('Import',true), 'cus-arrow-in');
echo $this->Admin->CreateTab('export',__('Export',true), 'cus-arrow-out');
echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('import');

    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));
    /*echo $this->Form->input('ImportExport.submittedfile', array('type' => 'file','label' => __('YML Import'),'between'=>'<br />'));*/
    echo $this->Form->file('submittedfile');
    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));// . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));	
    echo $this->Form->end();
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('export');
    echo $this->Form->create('form_Export', array('id' => 'contentform_export', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));
    
    echo '<table class="contentTable">';
    echo $this->Html->tableHeaders(array(__('Name table'), '<input type="checkbox" onclick="checkAll(this)" />'));
    foreach ($table_names AS $table_name => $fields)
    {
        echo $this->Admin->TableCells(array($table_name
                                        ,array($this->Form->checkbox($table_name, array('value' => 1)), array('align'=>'center'))
                                      ));
    }
    echo '</table>';
    
    echo '<div class="input text">';
        echo '<label for = "selected_content">' . __('Filter') . ' :</label> <select name="data[form_Export][sel_content]" id="selected_content">';
        echo '<option value="0">' .  __('all category') . '</option>';
        foreach ($sel_content AS $k => $sel_category)
        {
            echo '<option value="' . $k . '">' . __($sel_category) . '</option>';
        }
        echo '</select>';
        //echo $this->Admin->TableCells(array(__('Check export content'),$this->Form->select('sel_content', $sel_content,  array('id' => 'selected_content', 'escape' => false, 'empty' => array( 0 => __('all content'))))));
    echo '</div>';

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));// . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));	
    echo $this->Form->end();
    
echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Admin->ShowPageHeaderEnd();

?>