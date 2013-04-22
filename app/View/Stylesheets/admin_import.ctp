<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-arrow-in');

echo $this->Form->create('Stylesheet', array('action' => '/stylesheets/admin_upload/', 'url' => '/stylesheets/admin_upload/', 'enctype' => 'multipart/form-data', 'id' => 'stylesheetImportForm'));
echo $this->Form->file('submittedfile');
echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit'));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();