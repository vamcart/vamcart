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