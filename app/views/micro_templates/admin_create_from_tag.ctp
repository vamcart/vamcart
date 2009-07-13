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

	echo $form->create('MicroTemplate', array('action' => '/micro_templates/admin_edit/', 'url' => '/micro_templates/admin_edit/'));
		
		echo $form->inputs(array(
					'fieldset' => __('Micro Template Details', true),
					'MicroTemplate/id' => array(
   				   		'type' => 'hidden'
	                ),  
					'MicroTemplate/alias' => array(
   				   		'label' => __('Alias', true)
	                ),
	                'MicroTemplate/tag_name' => array(
   				   		'label' => __('Tag Name', true)
	                ),
					'MicroTemplate/template' => array(
						'type' => 'textarea',
   				   		'label' => __('Template', true)
	                ),
				));

	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Apply', true), array('name' => 'apply')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>