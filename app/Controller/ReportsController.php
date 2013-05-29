<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class ReportsController extends AppController {
    public $name = 'Reports';
    public $uses = array('Report'); 
    public $helpers = array('Html','Js','Admin','Form', 'FlashChart');
   
    public function admin($action = 'new')
    {
 
        $this->set('current_crumb', __('Sales Report', true));
        $this->set('title_for_layout', __('Sales Report', true));

        $order_status = array();
        $options = array();
        
        $l = $this->Session->read('Config.language');
        
        if (NULL == $l) {
            $l = $this->Session->read('Customer.language');
        }
  
        if($action == 'new')
        {
            $this->loadModel('OrderStatusDescription');
            $order_status = $this->OrderStatusDescription->find('all',  array('conditions' => array('language_id' => $this->Session->read('Customer.language_id'))));
            foreach ($order_status as $k => $status) 
            {
                $status['OrderStatus']['default'] = '1';
                $order_status[$k] = $status;

            }
            $options = array('period' => 'day'
                            ,'statuses' => $order_status
                            ,'stamp_dat' => null
                            ,'group_dat' => null);
            $this->Session->write('Reports.options', $options);
            $this->redirect('/reports/admin/show');
        }
        elseif($action == 'show')
        { 
            $listStatuses = array();
            $options = $this->Session->read('Reports.options');
            
            foreach ($options['statuses'] as $k => $status) 
            {
                if($status['OrderStatus']['default'] == '1') $listStatuses[$k] = $status['OrderStatus']['id'];
            }

            switch ($options['period'])
            {
                case 'hour':
                    $options['stamp_dat'] = date("Y-m-d H:i:s",time()-(24*3600));
                    $options['group_dat'] = '%m/%d %H:00';
                break;
                case 'day':
                    $options['stamp_dat'] = date("Y-m-d H:i:s",time()-(7*24*3600));
                    $options['group_dat'] = '%m/%d';
                break;
                case 'week':
                    $options['stamp_dat'] = date("Y-m-d H:i:s",time()-(30*24*3600));
                    $options['group_dat'] = '%Y/%m   %u '.__('week');
                break;
                case 'month':
                    $options['stamp_dat'] = date("Y-m-d H:i:s",time()-(365*24*3600));
                    $options['group_dat'] = '%Y/%m';
                break;
                case 'year':
                    /*
                     От определенной даты
                     $options['stamp_dat'] = date("Y-m-d H:i:s",time()-((date('Y')-2013)*365*24*3600));
                    */
                    $options['stamp_dat'] = date("Y-m-d H:i:s",time()-(10*365*24*3600));
                    $options['group_dat'] = '%Y';
                break;
                default :
                break;
            }
            
            $this->loadModel('Order');
            $order = $this->Order->find('all', array('fields' => array('DATE_FORMAT(Order.created, \''.$options['group_dat'].'\') as dat','TRUNCATE(SUM(Order.total),2) as summ','COUNT(Order.id) as cnt')
                                                    ,'conditions' => array('Order.order_status_id' => $listStatuses
                                                                          ,'Order.created >' => $options['stamp_dat'])
                                                    ,'group' => array('dat')
                                                    ,'order' => array('dat')));
            
            $result = array();
            foreach ($order as $k => $ord) 
            {
                $result['dat'][$k] = $ord[0]['dat'];
                $result['cnt'][$k] = $ord[0]['cnt'];
                $result['summ'][$k] = $ord[0]['summ'];
            } 

           $this->set('result',$result);
           $this->set('statuses',$options['statuses']);
           $this->set('period',$options['period']);
        }
        else
        {
            $this->redirect('/reports/admin/');
        }

    }
    
    public function admin_change_active_status ($id) 
    {
       
        $options = $this->Session->read('Reports.options');

        if($options['statuses'][$id]['OrderStatus']['default'] == '0')
        {
            $options['statuses'][$id]['OrderStatus']['default'] = '1';
        }
        else $options['statuses'][$id]['OrderStatus']['default'] = '0';
        
        $this->Session->write('Reports.options', $options);
        $this->redirect('/reports/admin/show');
       
    }
    
    public function admin_change_date ($date = 'day') 
    {
        $options = $this->Session->read('Reports.options');
        $options['period'] = $date;
        $this->Session->write('Reports.options', $options);
        $this->redirect('/reports/admin/show');
    }


}
