<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'import.png');

echo $this->Form->create('Templates', array('action' => '/templates/admin_upload/', 'url' => '/templates/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'templatesImportForm'));
echo $this->Form->file('submittedfile');
echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();
