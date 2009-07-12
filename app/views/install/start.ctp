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
<div class="pageheader"><?php __('Welcome to the Selling Made Simple installation.') ?></div>
<p><?php __('Installing version:') ?> <?php echo $version; ?></p>

<?php
echo $this->requestAction('/install/check_permissions/',array('return'=>true));
?>
<br /><br />
<h2><?php __('Step 2 - Enter Database Information') ?></h2>

<?php
echo $form->create('Install', array('action' => '/install/create/', 'url' => '/install/create/'));


echo $form->inputs(array(
				'fieldset' => __('install', true),
                'Install/db_host' => array(
			   		'label' => __('Host', true),
					'value' => $values['Install']['db_host']
                ),
                'Install/db_name' => array(
			   		'label' => __('Database Name', true),
					'value' => $values['Install']['db_name']
                ),
                'Install/db_username' => array(
			   		'label' => __('Database Username', true),
					'value' => $values['Install']['db_username']
                ),
                'Install/db_password' => array(
			   		'label' => __('Database Password', true),
					'type' => 'password',
					'value' => $values['Install']['db_password']
                ))
				);
		
echo '<br />';		
		
echo $form->submit( __('Submit', true)) ;


echo '<div style="clear:both;"></div>';
echo $form->end();

?>