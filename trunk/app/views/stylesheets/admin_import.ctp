<?php
echo $admin->ShowPageHeaderStart($current_crumb, 'stylesheets.png');

echo $form->create('Stylesheet', array('action' => '/stylesheets/admin_upload/', 'url' => '/stylesheets/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'stylesheetImportForm'));
echo $this->Form->file('submittedfile');
echo $this->Form->submit();
echo $form->end(); 

echo $admin->ShowPageHeaderEnd();