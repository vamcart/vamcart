<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-arrow-in');

echo $this->Form->create('MicroTemplates', array('action' => '/micro_templates/admin_upload/', 'url' => '/micro_templates/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'templatesImportForm'));
echo $this->Form->file('submittedfile');
echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();
