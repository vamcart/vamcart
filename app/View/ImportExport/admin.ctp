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

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));// . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));	
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Admin->ShowPageHeaderEnd();

?>