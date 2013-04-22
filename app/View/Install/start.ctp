<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-lightbulb');
?>
<p><?php echo __('Welcome to the VamCart installation.') ?></p>
<p><?php echo __('Installing version:') ?> <?php echo $version; ?></p>

<?php

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

echo $this->requestAction(array('controller' => 'install', 'action' => 'check_permissions'), array('return'));

?>
<br />
<?php
echo $this->Form->create('Install', array('id' => 'contentform', 'action' => '/install/create/', 'url' => '/install/create/'));
echo $this->Form->input('db_host', array(
												'label' => false, 
												'tooltip' => __('Host'), 
												'div' => 'input input-prepend', 
												'before' => '<span class="add-on"><i class="icon-home"></i></span>',  
												'value' => $values['Install']['db_host']
												));
												
echo $this->Form->input('db_name', array(
												'label' => false, 
												'tooltip' => __('Database Name'), 
												'div' => 'input input-prepend', 
												'before' => '<span class="add-on"><i class="icon-briefcase"></i></span>', 
												'value' => $values['Install']['db_name']
												));
												
echo $this->Form->input('db_username', array(
												'label' => false, 
												'tooltip' => __('Database Username'), 
												'div' => 'input input-prepend', 
												'before' => '<span class="add-on"><i class="icon-user"></i></span>', 
												'value' => $values['Install']['db_username']
												));
												
echo $this->Form->input('db_password', array(
												'label' => false, 
												'tooltip' => __('Database Password'), 
												'div' => 'input input-prepend', 
												'before' => '<span class="add-on"><i class="icon-pencil"></i></span>', 
												'value' => $values['Install']['db_password']
												));
												
echo '<div>'.__('Admin Credentials').'</div>';

echo $this->Form->input('username', array(
												'label' => false, 
												'tooltip' => __('Username'), 
												'div' => 'input input-prepend', 
												'before' => '<span class="add-on"><i class="icon-user"></i></span>', 
												'value' => $values['Install']['username']
												));
												
echo $this->Form->input('email', array(
												'label' => false, 
												'tooltip' => __('Email'), 
												'div' => 'input input-prepend', 
												'before' => '<span class="add-on"><i class="icon-envelope"></i></span>', 
												'value' => $values['Install']['email']
												));

echo $this->Form->input('password', array(
												'label' => false, 
												'tooltip' => __('Password'), 
												'div' => 'input input-prepend', 
												'before' => '<span class="add-on"><i class="icon-pencil"></i></span>', 
												'value' => $values['Install']['password']
												));

echo '<br />';

echo $this->Admin->formButtonCatalog(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));

echo '<div class="clear"></div>';
echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>