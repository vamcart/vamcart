<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
switch($content_type_id) {
	case '1':
		echo $this->Form->input('ContentCategory.extra', 
			array(
				'type' => 'hidden',
				'value' => 1
			));
		break;
	case '2':
	default:
		$tax_options = $this->requestAction('/contents/generate_tax_list/');

		echo $this->Form->input('ContentProduct.price', 
			array(
				'label' => __('Price'),
				'type' => 'text',
				'value' => !isset($data['ContentProduct']['price'])? 0 : $data['ContentProduct']['price']
			));
		echo $this->Form->input('ContentProduct.tax_id', 
			array(
				'label' => __('Tax Class'),
				'type' => 'select',
				'options' => $tax_options,
				'selected' => isset($data['ContentProduct']['tax_id']) ? $data['ContentProduct']['tax_id']: ''
			));
		echo $this->Form->input('ContentProduct.stock', 
			array(
				'label' => __('Stock'),
				'type' => 'text',
				'value' => !isset($data['ContentProduct']['stock'])? 0 : $data['ContentProduct']['stock']
			));
		echo $this->Form->input('ContentProduct.model', 
			array(
				'label' => __('Model'),
				'type' => 'text',
				'value' => isset($data['ContentProduct']['model']) ? $data['ContentProduct']['model']: ''
			));
		echo $this->Form->input('ContentProduct.weight', 
			array(
				'label' => __('Weight'),
				'after' => ' '.__('kg.'),
				'type' => 'text',
				'value' => !isset($data['ContentProduct']['weight'])? 0 : $data['ContentProduct']['weight']
			));
		break;
	case '3':
		echo $this->Form->input('ContentPage.extra', 
			array(
				'type' => 'hidden',
				'value' => 1
			));
		break;
	case '4':
		echo $this->Form->input('ContentLink.url', 
			array(
				'type' => 'text',
				'label' => __('URL'),
				'value' => isset($data['ContentLink']['url']) ? $data['ContentLink']['url'] : ''
			));
		break;
	case '5':
		echo $this->Form->input('ContentNews.extra', 
			array(
				'type' => 'hidden',
				'value' => 1
			));
		break;
	case '6':
		echo $this->Form->input('ContentArticle.extra', 
			array(
				'type' => 'hidden',
				'value' => 1
			));
		break;
	case '7':
		$tax_options = $this->requestAction('/contents/generate_tax_list/');
		$order_statuses = $this->requestAction('/contents/generate_order_statuses_list/');

		echo $this->Form->input('ContentDownloadable.price', 
			array(
				'label' => __('Price'),
				'type' => 'text',
				'value' => !isset($data['ContentDownloadable']['price'])? 0 : $data['ContentDownloadable']['price']
			));
		echo $this->Form->input('ContentDownloadable.tax_id', 
			array(
				'label' => __('Tax Class'),
				'type' => 'select',
				'options' => $tax_options,
				'selected' => isset($data['ContentDownloadable']['tax_id']) ? $data['ContentDownloadable']['tax_id'] : ''
			));
		echo $this->Form->input('ContentDownloadable.order_status_id', 
			array(
				'label' => __('Required order status to download'),
				'type' => 'select',
				'options' => $order_statuses,
				'selected' => isset($data['ContentDownloadable']['order_status_id']) ? $data['ContentDownloadable']['order_status_id'] : ''
			));
		echo $this->Form->input('ContentDownloadable.model', 
			array(
				'label' => __('Model'),
				'type' => 'text',
				'value' => isset($data['ContentDownloadable']['model']) ? $data['ContentDownloadable']['model'] : ''
			));
		echo $this->Form->input('ContentDownloadable.file', 
			array(
				'label' => __('File: ') . (isset($data['ContentDownloadable']['filename']) ? $data['ContentDownloadable']['filename'] : ''),
				'type' => 'file',
				'value' => isset($data['ContentDownloadable']['filename']) ? $data['ContentDownloadable']['filename'] : ''
			));
		echo $this->Form->input('ContentDownloadable.delete', 
			array(
				'label' => __('delete '),
				'type' => 'checkbox'
			));
		echo $this->Form->input('ContentDownloadable.max_downloads', 
			array(
				'label' => __('Max. downloads'),
				'type' => 'text',
				'value' => isset($data['ContentDownloadable']['max_downloads']) ? $data['ContentDownloadable']['max_downloads'] : ''
			));
		echo $this->Form->input('ContentDownloadable.max_days_for_download', 
			array(
				'label' => __('Max. days for download'),
				'type' => 'text',
				'value' => isset($data['ContentDownloadable']['max_days_for_download']) ? $data['ContentDownloadable']['max_days_for_download'] : ''
			));
		break;
}