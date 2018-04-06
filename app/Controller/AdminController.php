<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class AdminController extends AppController {
	public $name = 'Admin';
	public $uses = array('User', 'Order');
	public $helpers = array('Html','Js','Admin','Form');

	public function index() 
	{
		$this->redirect('/users/admin_login/');
	}
	
	public function admin_top($level = 1)
	{
            $this->set('current_crumb', __('Dashboard', true));	
            $this->set('title_for_layout', __('Dashboard', true));
            
            $l = $this->Session->read('Config.language');
            if (NULL == $l) {
                $l = $this->Session->read('Customer.language');
            }
                
            $order_day = $this->Order->find('all', array('fields' => array('DATE_FORMAT(Order.created, \'%m-%d-%Y\') as dat','TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array('Order.order_status_id >' => '0','Order.created >' => date("Y-m-d H:i:s",time()-(14*24*3600)))
                                                    ,'group' => array('dat')
                                                    ,'order' => array('dat')));
            $order_month = $this->Order->find('all', array('fields' => array('DATE_FORMAT(Order.created, \'%Y-%m\') as dat','TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array('Order.order_status_id >' => '0','Order.created >' => date("Y-m-d H:i:s",time()-(365*24*3600)))
                                                    ,'group' => array('dat')
                                                    ,'order' => array('dat')));
                                                    
            $order_day_year_ago = $this->Order->find('all', array('fields' => array('DATE_FORMAT(Order.created, \'%m-%d-%Y\') as dat','TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array('Order.order_status_id >' => '0','Order.created >' => date("Y-m-d H:i:s",strtotime("-1 year", time())-(14*24*3600)),'Order.created <' => date("Y-m-d H:i:s",time()-(365*24*3600)))
                                                    ,'group' => array('dat')
                                                    ,'order' => array('dat')));
            $order_month_year_ago = $this->Order->find('all', array('fields' => array('DATE_FORMAT(Order.created, \'%Y-%m\') as dat','TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array('Order.order_status_id >' => '0','Order.created >' => date("Y-m-d H:i:s",strtotime("-1 year", time())-(365*24*3600)),'Order.created <' => date("Y-m-d H:i:s",time()-(365*24*3600)))
                                                    ,'group' => array('dat')
                                                    ,'order' => array('dat')));

            $result = false;

				if ($order_day or $order_day) {
            $result = array();

            foreach ($order_day as $k => $ord) 
            {
                $result['dat'][$k] = $ord[0]['dat'];
                $result['cnt'][$k] = $ord[0]['cnt'];
                $result['summ'][$k] = $ord[0]['summ'];
                $result['jq_plot_cnt'][$k] = '["'.$ord[0]['dat'].'" ,'.$ord[0]['cnt'].']';
                $result['jq_plot_summ'][$k] = '["'.$ord[0]['dat'].'" ,'.$ord[0]['summ'].']';
            } 
            $result = array('day' => $result
                           ,'month' => array());
            foreach ($order_month as $k => $ord) 
            {
                $result['month']['dat'][$k] = $ord[0]['dat'];
                $result['month']['cnt'][$k] = $ord[0]['cnt'];
                $result['month']['summ'][$k] = $ord[0]['summ'];
                $result['month']['jq_plot_cnt'][$k] = '["'.$ord[0]['dat'].'" , '.$ord[0]['cnt'].']';
                $result['month']['jq_plot_summ'][$k] = '["'.$ord[0]['dat'].'" , '.$ord[0]['summ'].']';
            }

				}

            $result_year_ago = false;

				if ($order_day_year_ago or $order_day_year_ago) {
            $result_year_ago = array();

            foreach ($order_day_year_ago as $k_year_ago => $ord_year_ago) 
            {
                $ord_year_ago[0]['dat'] = date("Y-m", strtotime("+1 year", strtotime($ord_year_ago[0]['dat'])));
                $result_year_ago['dat'][$k_year_ago] = $ord_year_ago[0]['dat'];
                $result_year_ago['cnt'][$k_year_ago] = $ord_year_ago[0]['cnt'];
                $result_year_ago['summ'][$k_year_ago] = $ord_year_ago[0]['summ'];
                $result_year_ago['jq_plot_cnt'][$k] = '["'.$ord_year_ago[0]['dat'].'" ,'.$ord_year_ago[0]['cnt'].']';
                $result_year_ago['jq_plot_summ'][$k] = '["'.$ord_year_ago[0]['dat'].'" ,'.$ord_year_ago[0]['summ'].']';
            } 
            $result_year_ago = array('day_year_ago' => $result_year_ago
                           ,'month_year_ago' => array());
            foreach ($order_month_year_ago as $k_year_ago => $ord_year_ago) 
            {
                $ord_year_ago[0]['dat'] = date("m-d-Y", strtotime("+1 year", strtotime($ord_year_ago[0]['dat'])));
                $result_year_ago['month_year_ago']['dat'][$k_year_ago] = $ord_year_ago[0]['dat'];
                $result_year_ago['month_year_ago']['cnt'][$k_year_ago] = $ord_year_ago[0]['cnt'];
                $result_year_ago['month_year_ago']['summ'][$k_year_ago] = $ord_year_ago[0]['summ'];
                $result_year_ago['month_year_ago']['jq_plot_cnt'][$k_year_ago] = '["'.$ord_year_ago[0]['dat'].'" , '.$ord_year_ago[0]['cnt'].']';
                $result_year_ago['month_year_ago']['jq_plot_summ'][$k_year_ago] = '["'.$ord_year_ago[0]['dat'].'" , '.$ord_year_ago[0]['summ'].']';
            }

				}
				
				App::import('Model', 'Content');
				$Content = new Content();	
		                        
				$Content->unbindAll();	
				$Content->bindModel(array('hasOne' => array(
						'ContentDescription' => array(
		                    'className' => 'ContentDescription',
							'conditions'   => 'language_id = '.$this->Session->read('Customer.language_id')
		                ))));
				$Content->bindModel(array('belongsTo' => array(
						'ContentType' => array(
		                    'className' => 'ContentType'
							))));			
				$Content->bindModel(array('hasOne' => array(
						'ContentImage' => array(
		                    'className' => 'ContentImage',
		                    'conditions'=>array('ContentImage.order' => '1')
							))));						
				$Content->bindModel(array('hasOne' => array(
						'ContentProduct' => array(
		                    'className' => 'ContentProduct'
							))));
							
            $content_ordered = $Content->find('all',array('fields' => array('Content.id', 'Content.alias','ContentProduct.ordered', 'ContentDescription.name', 'ContentImage.image')
                                                       ,'conditions' => array('Content.content_type_id' => 2)
                                                       , 'limit' => 10
                                                       ,'order' => array('ContentProduct.ordered DESC')
                                                                ));

				if ($content_ordered) {
            $top_products = $content_ordered;
            }

            $this->set('result',$result);	
            $this->set('result_year_ago',$result_year_ago);	
            $this->set('top_products',$top_products);	
            $this->set('level', $level);

		// Last orders

		$data = $this->Order->find('all', array(	'conditions' => array('Order.order_status_id >' => '0'), 
																'order' => array('Order.id DESC'), 
																'limit' => 18
															));

		// Bind and set the order status select list
		$this->Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->Order->OrderStatus->bindModel(
	        array('hasOne' => array(
				'OrderStatusDescription' => array(
                    'className' => 'OrderStatusDescription',
					'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );		
		
		$status_list = $this->Order->OrderStatus->find('all', array('order' => array('OrderStatus.order ASC')));
		$order_status_list = array();
		
		foreach($status_list AS $status)
		{
			$status_key = $status['OrderStatus']['id'];
			$order_status_list[$status_key] = $status['OrderStatusDescription']['name'];
		}
		
		$this->set('order_status_list',$order_status_list);

		$this->set('data',$data);

		// Total orders

				$this->Order->unbindAll();	

            $total_orders = $this->Order->find('first', array('fields' => array('TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array('Order.order_status_id >' => '0')));

		// Pending orders

            //Get default order status
            
				App::import('Model', 'OrderStatus');
				$OrderStatus = new OrderStatus();	

				$pending_orders = $OrderStatus->find('first', array('conditions' => array('default' => '1')));

				$this->Order->unbindAll();	

            $pending_orders = $this->Order->find('count', array('conditions' => array('Order.order_status_id' => $pending_orders['OrderStatus']['id'])));

		// Total customers

				App::import('Model', 'Customer');
				$Customer = new Customer();	
		                        
				$Customer->unbindAll();	

            $total_customers = $Customer->find('count');

		$this->set('total_orders',$total_orders[0]['cnt']);
		$this->set('pending_orders',$pending_orders);
		$this->set('total_sales',($total_orders[0]['summ'] > 0) ? number_format($total_orders[0]['summ'], 0) : 0);
		$this->set('average_order',($total_orders[0]['summ'] > 0) ? number_format($total_orders[0]['summ']/$total_orders[0]['cnt'], 0) : 0);
		$this->set('total_customers',$total_customers);

			
	}
}
?>