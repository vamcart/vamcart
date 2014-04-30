<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

    $this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
    ), array('inline' => false));

    echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-group-edit');
    echo $this->Form->create('GroupsCustomer', array('id' => 'contentform', 'action' => '/groups_customers/admin_save/', 'url' => '/groups_customers/admin_save/'));
    echo $this->Form->input('GroupsCustomer.id', 
						array(
				   		'type' => 'hidden'
	               ));

    echo '<ul id="myTabLang" class="nav nav-tabs">';
    foreach($languages AS $language)
    {
        echo $this->Admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],'cus-page-white');
    }
    echo '</ul>';
    echo $this->Admin->StartTabs('sub-tabs');
    
    foreach($languages AS $k => $language)
    {
        $language_key = $language['Language']['id'];
        echo $this->Admin->StartTabContent('language_'.$language_key);
        
        echo $this->Form->input('GroupsCustomerDescription.' . $language_key . '.id',array('type' => 'hidden'
	               ));
        echo $this->Form->input('GroupsCustomerDescription.' . $language_key . '.language_id',array('type' => 'hidden'
                                           ,'value' => $language_key
	               ));
        echo $this->Form->input('GroupsCustomerDescription.' . $language_key . '.name', 
                		array(
				'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Group Name'),
				'type' => 'text'
                                ));
        echo $this->Admin->EndTabContent();
    }
    echo $this->Admin->EndTabs();

    echo $this->Form->input('GroupsCustomer.price', 
						array(
   				   		'label' => __('Discount'),
   				   		'after' => ' %'
	               ));
    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));    
    echo '<div class="clear"></div>';
    echo $this->Form->end();    
    echo $this->Admin->ShowPageHeaderEnd();         

?>