<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $javascript->link('modified', false);

echo '<div class="page">';
echo '<h2>'.$admin->ShowPageHeader($current_crumb, 'new.png').'</h2>';
echo '<div class="pageContent">';

	echo $form->create('MicroTemplate', array('id' => 'contentform', 'action' => '/micro_templates/admin_edit/', 'url' => '/micro_templates/admin_edit/'));
		
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Micro Template Details', true),
					'MicroTemplate.id' => array(
   				   		'type' => 'hidden'
	                ),  
					'MicroTemplate.alias' => array(
   				   		'label' => __('Alias', true)
	                ),
	                'MicroTemplate.tag_name' => array(
   				   		'label' => __('Tag Name', true)
	                ),
					'MicroTemplate.template' => array(
						'type' => 'textarea',
   				   		'label' => __('Template', true)
	                ),
				));

	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Apply', true), array('name' => 'apply')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
echo '</div>';
echo '</div>';
	
	?>