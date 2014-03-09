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
	public $helpers = array('Html','Js','Admin','Form', 'FlashChart');

	public function index() 
	{
		$this->redirect('/users/admin_login/');
	}
	
	public function admin_top($level = 1)
	{
            $this->set('current_crumb', __('', true));	
            $this->set('title_for_layout', __('Dashboard', true));
            
            $l = $this->Session->read('Config.language');
            if (NULL == $l) {
                $l = $this->Session->read('Customer.language');
            }
                
            //App::import('Model', 'Order');
            //$this->Order =& new Order();
            $this->loadModel('Order');
            
            $order_day = $this->Order->find('all', array('fields' => array('DATE_FORMAT(Order.created, \'%m/%d\') as dat','TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array(/*'Order.order_status_id' => $listStatuses
                                                                          ,*/'Order.created >' => date("Y-m-d H:i:s",time()-(30*24*3600)))
                                                    ,'group' => array('dat')
                                                    ,'order' => array('dat')));
            $order_month = $this->Order->find('all', array('fields' => array('DATE_FORMAT(Order.created, \'%Y/%m\') as dat','TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array(/*'Order.order_status_id' => $listStatuses
                                                                          ,*/'Order.created >' => date("Y-m-d H:i:s",time()-(365*24*3600)))
                                                    ,'group' => array('dat')
                                                    ,'order' => array('dat')));
            $result = array();
            foreach ($order_day as $k => $ord) 
            {
                $result['dat'][$k] = $ord[0]['dat'];
                $result['cnt'][$k] = $ord[0]['cnt'];
                $result['summ'][$k] = $ord[0]['summ'];
            } 
            $result = array('day' => $result
                           ,'month' => array());
            foreach ($order_month as $k => $ord) 
            {
                $result['month']['dat'][$k] = $ord[0]['dat'];
                $result['month']['cnt'][$k] = $ord[0]['cnt'];
                $result['month']['summ'][$k] = $ord[0]['summ'];
            }

				App::import('Model', 'Content');
				$Content =& new Content();	
		                        
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
            $result['content_ordered'] = $content_ordered;

            $this->set('result',$result);	
            $this->set('level', $level);

		// Last orders
		
		$this->Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->Order->OrderStatus->bindModel(
	        array('hasOne' => array(
				'OrderStatusDescription' => array(
                    'className' => 'OrderStatusDescription',
					'conditions'   => 'OrderStatusDescription.language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );			
	

		$this->Order->recursive = 2;
		
		$data = $this->Order->find('all', array(	'conditions' => array('Order.order_status_id >' => '0'), 
																'order' => array('Order.id DESC'), 
																'limit' => 20
															));

		$this->set('data',$data);
			
	}
}
?>