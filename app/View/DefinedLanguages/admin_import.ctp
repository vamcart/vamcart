<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'import.png');

echo $this->Form->create('DefinedLanguages', array('action' => '/defined_languages/admin_upload/', 'url' => '/defined_languages/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'languagesImportForm'));
echo $this->Form->file('submittedfile');
echo $this->Admin->formButton(__('Submit'), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();