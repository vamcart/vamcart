<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

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