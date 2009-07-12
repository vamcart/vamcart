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

	$id = $this->data['MicroTemplate']['id'];
	echo $form->create('MicroTemplate', array('action' => '/micro_templates/admin_edit/'.$id, 'url' => '/micro_templates/admin_edit/'.$id));
		
		echo $form->inputs(array(
					'fieldset' => __('micro_template_details', true),
					'MicroTemplate/id' => array(
   				   		'type' => 'hidden'
	                ),  
					'MicroTemplate/alias' => array(
   				   		'label' => __('alias', true)
	                ),
	                'MicroTemplate/tag_name' => array(
   				   		'label' => __('tag_name', true)
	                ),
					'MicroTemplate/template' => array(
						'type' => 'textarea',
   				   		'label' => __('template', true)
	                ),
				));

	echo $form->submit('Submit', array('name' => 'submit')) . $form->submit('Apply', array('name' => 'apply')) . $form->submit('Cancel', array('name' => 'cancel'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>