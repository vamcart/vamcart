<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

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

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));
    echo $this->Form->file('submittedfile');
    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('export');
    echo $this->Form->create('form_Export', array('id' => 'contentform_export', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));
    
    echo '<table class="contentTable">';
    echo $this->Html->tableHeaders(array(__('Data'), '<input type="checkbox" onclick="checkAll(this)" />'));
    foreach ($table_names AS $table_name => $fields)
    {
        echo $this->Admin->TableCells(array($table_name
                                        ,array($this->Form->checkbox($table_name, array('value' => 1)), array('align'=>'center'))
                                      ));
    }
    echo '</table>';
    
    echo '<div class="input text">';
        echo __('Filter') . ': <select name="data[form_Export][sel_content]" id="selected_content">';
        echo '<option value="0">' .  __('All Categories') . '</option>';
        foreach ($sel_content AS $k => $sel_category)
        {
            echo '<option value="' . $k . '">' . __($sel_category[0]) . '</option>';
        }
        echo '</select>';
    echo '</div>';
    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();
    
echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Admin->ShowPageHeaderEnd();

?>