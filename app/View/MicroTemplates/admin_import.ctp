<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'import.png');

echo $this->Form->create('MicroTemplates', array('action' => '/micro_templates/admin_upload/', 'url' => '/micro_templates/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'templatesImportForm'));
echo $this->Form->file('submittedfile');
echo $this->Admin->formButton(__('Submit'), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();
