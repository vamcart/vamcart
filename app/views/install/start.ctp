<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
?>
<p><?php __('Welcome to the VaM Shop installation.') ?></p>
<p><?php __('Installing version:') ?> <?php echo $version; ?></p>

<?php
echo $this->requestAction(array('controller' => 'install', 'action' => 'check_permissions'), array('return'));

?>
<br />
<?php
echo $form->create('Install', array('action' => '/install/create/', 'url' => '/install/create/'));
echo $form->input('db_host', array('label' => __('Host',true), 'value' => $values['Install']['db_host']));
echo $form->input('db_name', array('label' => __('Database Name',true), 'value' => $values['Install']['db_name']));
echo $form->input('db_username', array('label' => __('Database Username',true), 'value' => $values['Install']['db_username']));
echo $form->input('db_password', array('label' => __('Database Password',true), 'value' => $values['Install']['db_password']));

echo '<br />';		
		
echo $form->submit( __('Submit', true)) ;


echo '<div class="clear"></div>';
echo $form->end();

?>