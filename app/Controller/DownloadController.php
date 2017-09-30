<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class DownloadController extends AppController {
	public $name = 'Download';
	public $components = array('ContentBase');
	public $uses = null;
	

	public function get() {
		App::import('Model', 'Order');
		App::import('Model', 'OrderProduct');
		$Order = new Order();


		if ($this->params['download_key'] == 'free') { 

			$content = $this->ContentBase->get_content_information($this->params['content_id']); 
			
			if ($content['Content']['content_type_id'] != 7) {
			
			die();
			
			} else {
			
					App::import('Model', 'ContentDownloadable');
					$ContentDownloadable = new ContentDownloadable();
					$product = $ContentDownloadable->find('first', array('conditions' => array('ContentDownloadable.content_id' => (int)$this->params['content_id'])));
					if (null !== $product) {
			
			   if ($product['ContentDownloadable']['price'] == 0) {
				if (file_exists('./downloads/' . $product['ContentDownloadable']['filestorename'])) {
					header('Content-Disposition: attachment; filename="' . $product['ContentDownloadable']['filename'] . '"');
					readfile('./downloads/' . $product['ContentDownloadable']['filestorename']);
				}
				} else {
              die(); 				
				}
			
			die();
			
			}
			
			}
		}

		$order = $Order->find('first', array('conditions' => array('Order.id' => (int)$this->params['order_id'])));
		if (null !== $order) {
			$downloadable_product = null;
			foreach ($order['OrderProduct'] as $product) {
				if ((int)$this->params['content_id'] == $product['id'] && $this->params['download_key'] == $product['download_key']) {
					$downloadable_product = $product;
					break;
				}
			}

			if ($downloadable_product) {
				if ($order['Order']['order_status_id'] == $downloadable_product['order_status_id']) {
					if (($downloadable_product['download_count'] < $downloadable_product['max_downloads']) || (0 == $downloadable_product['max_downloads'])) { // проверка на количество скачиваний
						if ((strtotime($order['Order']['created']) + $downloadable_product['max_days_for_download']*24*60*60 - time())*$downloadable_product['max_days_for_download'] >= 0) { // проверка предельно допустимой даты скачивания
							$file_store_name = $downloadable_product['filestorename'];
							$file_name = $downloadable_product['filename'];

							$OrderProduct = new OrderProduct();
							$order_product = $OrderProduct->findById($downloadable_product['id']);
							$order_product['OrderProduct']['download_count']++;
							$OrderProduct->save($order_product);

							if (file_exists('./downloads/' . $file_store_name)) {
								header('Content-Disposition: attachment; filename="' . $file_name . '"');
								readfile('./downloads/' . $file_store_name);
							}
							
							die;
						} else {
							echo __('Last allowed download date is reached.', true);
							die;
						}
					} else {
						echo __('The number of downloads is exceeded.', true);
						die;
					}
				} else {
					echo __('Order is not payed.', true);
					die;
				}
			} else {
				echo __('Product is not found.', true);
				die;
			}
		} else {
			echo __('Order is not found.', true);
			die;
		}
		
	}
	
	public function free_download($content_id = 0) {

			$content = $this->ContentBase->get_content_information($content_id);                      
			echo var_dump($content);
	if (file_exists('./downloads/' . $file_store_name)) {
		header('Content-Disposition: attachment; filename="' . $file_name . '"');
		readfile('./downloads/' . $file_store_name);
	}

	}
		
}
?>