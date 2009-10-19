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

	echo $form->create('EmailTemplate', array('id' => 'contentform', 'action' => '/email_template/admin_edit/' . $data['EmailTemplate']['id'], 'url' => '/email_template/admin_edit/' . $data['EmailTemplate']['id']));
	echo $form->inputs(array(
					'fieldset' => __('Email Templates Details', true),
				   'EmailTemplate.id' => array(
				   		'type' => 'hidden',
						'value' => $data['EmailTemplate']['id']
	               )
		 ));

		echo $form->inputs(array(
	               'EmailTemplate.alias' => array(
   				   		'label' => __('Alias', true),				   
   						'value' => $data['EmailTemplate']['alias']
	               )
				));

	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
	   	echo $form->inputs(array('EmailTemplateDescription.' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('Subject (%s) ', true),__($language['Language']['name'], true)),
						'value' => $data['EmailTemplateDescription'][$language_key]['subject']
	            	  ) 	   																									
				));
		echo $form->inputs(array('EmailTemplateDescription.' . $language['Language']['id'] => array(
			   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('Content (%s) ', true),__($language['Language']['name'], true)),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',											
					'value' => $data['EmailTemplateDescription'][$language_key]['content']
            	  )));
				
	}
	
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>