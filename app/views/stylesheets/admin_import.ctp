<?php
echo $admin->ShowPageHeaderStart($current_crumb, 'import.png');

echo $form->create('Stylesheet', array('action' => '/stylesheets/admin_upload/', 'url' => '/stylesheets/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'stylesheetImportForm'));
echo $this->Form->file('submittedfile');
echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $form->end(); 

echo $admin->ShowPageHeaderEnd();