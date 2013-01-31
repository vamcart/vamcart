<?php
echo $admin->ShowPageHeaderStart($current_crumb, 'import.png');

echo $form->create('DefinedLanguages', array('action' => '/defined_languages/admin_upload/', 'url' => '/defined_languages/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'languagesImportForm'));
echo $this->Form->file('submittedfile');
echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $form->end(); 

echo $admin->ShowPageHeaderEnd();