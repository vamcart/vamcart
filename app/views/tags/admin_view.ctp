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

echo $html->script('modified', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'view.png');

echo $help_content;

echo '<div class="pageheader">' . __('About', true) . '</div>';
echo $about_content;

if(isset($default_template))
{
	echo '<div class="pageheader">' . __('Default Template', true) . '</div>';
	
		echo $form->create('MicroTemplate', array('id' => 'contentform', 'action' => '/micro_templates/admin_create_from_tag/', 'url' => '/micro_templates/admin_create_from_tag/'));
		
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Template Details', true),
					'MicroTemplate.tag_name' => array(
						'value' => $tag_name,
   				   		'type' => 'hidden'
	                ),
					'MicroTemplate.tag_type' => array(
						'value' => $tag_type,
   				   		'type' => 'hidden'
	                ),
					'MicroTemplate.template' => array(
						'type' => 'textarea',
				   	'label' => __('Template', true),
						'value' => $default_template,
						'onfocus' => 'this.select();'
					)
				));

	echo $admin->formButton(__('Create Micro Template From Tag', true), 'submit.png', array('type' => 'submit', 'name' => 'submit'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
}

echo $admin->ShowPageHeaderEnd();

?>