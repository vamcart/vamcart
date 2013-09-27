<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Form->input('Order.order_status_id', 
			array(
				'type' => 'select',
				'options' => $order_status_list,
				'label' => __('Update Status')
			));
	echo '<div class="clear"></div>';			
	echo $this->Form->input('Order.answer_template_id', 
			array(
				'type' => 'select',
				'options' => $answer_template_list,
				'label' => __('Answer Template'),
				'name' => 'menu',
				'empty' => __('Select'),
				'onclick' => 'var textarea = document.getElementById("OrderCommentComment"); textarea.value=document.getElementById("OrderAnswerTemplateId").value;',
				'after' => ' '.$this->Html->link($this->Html->image("admin/icons/new.png", array('alt' => __('Add Answer Template'), 'title' => __('Add Answer Template'))),'/answer_template/admin/', array('escape' => false, 'target' => '_blank'))
			));
	echo $this->Form->input('OrderComment.comment', 
			array(
				'type' => 'textarea',
				'label' => __('Comment'),
				'class' => 'pagesmallesttextarea'
			));
	echo $this->Form->input('OrderComment.sent_to_customer', 
			array(
				'type' => 'checkbox',
				'label' => __('Send To Customer'),
				'class' => 'checkbox_group'
			));

?>