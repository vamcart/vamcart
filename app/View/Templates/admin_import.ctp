<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-arrow-in');

echo $this->Form->create('Templates', array('url' => '/templates/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'templatesImportForm'));
echo $this->Form->file('submittedfile');
echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();
