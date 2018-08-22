<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Form->input('Customer.answer_template_id', 
			array(
				'type' => 'select',
				'options' => $answer_template_list,
				'label' => __('Answer Template'),
				'name' => 'menu',
				'id' => 'answer_template_id',
				'empty' => __('Select'),
				'onclick' => 'var textarea = document.getElementById("message"); textarea.value=document.getElementById("answer_template_id").value;',
				'after' => ' '.$this->Html->link($this->Html->image("admin/icons/new.png", array('alt' => __('Add Answer Template'), 'title' => __('Add Answer Template'))),'/answer_template/admin/', array('escape' => false, 'target' => '_blank'))
			));
	echo $this->Form->input('Customer.message', 
			array(
				'type' => 'textarea',
				'id' => 'message',
				'label' => __('Message'),
				'class' => 'pagesmallesttextarea'
			));

?>