<?php
echo $admin->ShowPageHeaderStart($current_crumb, 'import.png');

echo $form->create('MicroTemplates', array('action' => '/micro_templates/admin_upload/', 'url' => '/micro_templates/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'templatesImportForm'));
echo $this->Form->file('submittedfile');
echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $form->end(); 

echo $admin->ShowPageHeaderEnd();
