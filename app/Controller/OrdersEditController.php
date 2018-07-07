<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class OrdersEditController extends AppController 
{
    public $name = 'OrdersEdit';
    public $paginate = null;
    public $helpers = array('Smarty');
    
    
    public function admin ($act = 'new', $id = 0)
    {
		$this->set('current_crumb', __('Order Edit', true));
		$this->set('title_for_layout', __('Order Edit', true));

        $order = array();
        
        $this->loadModel('Order');
        
        $bill_state = $this->Order->BillState->find('list',array('fields' => array('id','name')));            
        $order['bill_state'] = array('data' => $bill_state
                                          ,'json_data' => array()
                                          ,'id_selected' => '0'
                                          ,'selected' => '_');
        $order['bill_state']['json_data'] = json_encode($order['bill_state']['data']);
                
        $bill_country = $this->Order->BillCountry->find('list',array('fields' => array('id','name')));
        function v($v){return __($v);}
        $bill_country = array_map("v",$bill_country);            
        $order['bill_country'] = array('data' => $bill_country
                                          ,'json_data' => array()
                                          ,'id_selected' => '0'
                                          ,'selected' => '_');
        function v1($v){return __($v);}
        $bill_country = array_map("v1",$bill_country);
        $order['bill_country']['json_data'] = json_encode($bill_country);
                
        $ship_state = $this->Order->ShipState->find('list',array('fields' => array('id','name')));            
        $order['ship_state'] = array('data' => $ship_state
                                          ,'json_data' => array()
                                          ,'id_selected' => '0'
                                          ,'selected' => '_');
        $order['ship_state']['json_data'] = json_encode($order['ship_state']['data']);
                
        $ship_country = $this->Order->ShipCountry->find('list',array('fields' => array('id','name'))); 
        function v2($v){return __($v);}           
        $ship_country = array_map("v2",$ship_country);
        $order['ship_country'] = array('data' => $ship_country
                                          ,'json_data' => array()
                                          ,'id_selected' => '0'
                                          ,'selected' => '_');
        $order['ship_country']['json_data'] = json_encode($ship_country);
                
        $pay_metd = $this->Order->PaymentMethod->find('list',array('fields' => array('id','name'), 'conditions' => array('PaymentMethod.active = 1')));            
        function v3($v){return __($v);}           
        $pay_metd = array_map("v3",$pay_metd);
        $order['pay_metd'] = array('data' => $pay_metd
                                          ,'json_data' => array()
                                          ,'id_selected' => '0'
                                          ,'selected' => '_');
        $order['pay_metd']['json_data'] = json_encode($order['pay_metd']['data']);

        $ship_metd = $this->Order->ShippingMethod->find('list',array('fields' => array('id','name'), 'conditions' => array('ShippingMethod.active = 1')));
        function v4($v){return __($v);}           
        $ship_metd = array_map("v4",$ship_metd);
        $order['ship_metd'] = array('data' => $ship_metd
                                          ,'json_data' => array()
                                          ,'id_selected' => '0'
                                          ,'selected' => '_');
        $order['ship_metd']['json_data'] = json_encode($order['ship_metd']['data']);       
        
        
        if($act == 'new')
        {
            $max_id = $this->Order->find('first',array('fields' => array('MAX(Order.id) as id')));
            $order['id'] = $max_id[0]['id'] + 1;
            $order['bill_inf'] = array('Customer_Name' => '','Address_Line_1' => '','Address_Line_2' => '','City' => '','Zip' => '');
            $order['ship_inf'] = array('Ship_Customer_Name' => '','Ship_Address_Line_1' => '','Ship_Address_Line_2' => '','Ship_City' => '','Ship_Zip' => '');
            $order['contact_inf'] = array('Email' => '','Phone' => '','Company' => '0');
            $order['shipping'] = 0;
            $order['tax'] = 0;
            $order['total'] = 0;
            $order['OrderProduct'] = array();
            
            $this->Session->write('order_edit.order', $order);
        }
        elseif ($act == 'redirect') 
        {
            $order = $this->Session->read('order_edit.order');
            //$this->redirect('/orders/admin/');
        }
        elseif ($act == 'edit') 
        {
            $this->loadModel('Order');
            $this->Order->Behaviors->attach('Containable');
            $o = $this->Order->find('first',array('conditions' => array('Order.id' => $id)
                                                       ,'contain' => array('OrderProduct','ShippingMethod','PaymentMethod', 'BillCountry', 'BillState', 'ShipCountry', 'ShipState')
                                                                ));          
            if(isset($o['Order']))
            {
                $order['id'] = $id;
                $order['customer_id'] = $o['Order']['customer_id'];
                $order['bill_inf'] = array('Customer_Name' => $o['Order']['bill_name']
                                          ,'Address_Line_1' => $o['Order']['bill_line_1']
                                          ,'Address_Line_2' => $o['Order']['bill_line_2']
                                          ,'City' => $o['Order']['bill_city']
                                          //,'State' => $o['BillState']['name']
                                          //,'Country' => $o['BillCountry']['name']
                                          ,'Zip' => $o['Order']['bill_zip']
                                          );

                $order['ship_inf'] = array('Ship_Customer_Name' => $o['Order']['ship_name']
                                          ,'Ship_Address_Line_1' => $o['Order']['ship_line_1']
                                          ,'Ship_Address_Line_2' => $o['Order']['ship_line_2']
                                          ,'Ship_City' => $o['Order']['ship_city']
                                          //,'Ship_State' => $o['ShipState']['name']
                                          //,'Ship_Country' => $o['ShipCountry']['name']
                                          ,'Ship_Zip' => $o['Order']['ship_zip']
                                          );
                $order['contact_inf'] = array('Email' => $o['Order']['email']
                                             ,'Phone' => $o['Order']['phone']
                                             ,'Company' => $o['Order']['company_name']
                                             );
                    
                $order['OrderProduct'] = $o['OrderProduct'];
                $order['shipping'] = $o['Order']['shipping'];
                $order['tax'] = $o['Order']['tax']; 
                $order['total'] = $o['Order']['total'];
         
                if(isset($o['BillState']['id']))
                $order['bill_state'] = array('data' => $order['bill_state']['data']
                                          ,'json_data' => $order['bill_state']['json_data']
                                          ,'id_selected' => $o['BillState']['id']
                                          ,'selected' => $o['BillState']['name']);
                          
                if(isset($o['BillCountry']['id']))
                $order['bill_country'] = array('data' => $order['bill_country']['data']
                                          ,'json_data' => $order['bill_country']['json_data']
                                          ,'id_selected' => $o['BillCountry']['id']
                                          ,'selected' => __($o['BillCountry']['name']));
                          
                if(isset($o['ShipState']['id']))
                $order['ship_state'] = array('data' => $order['ship_state']['data']
                                          ,'json_data' => $order['ship_state']['json_data']
                                          ,'id_selected' => $o['ShipState']['id']
                                          ,'selected' => $o['ShipState']['name']);
                           
                if(isset($o['ShipCountry']['id']))
                $order['ship_country'] = array('data' => $order['ship_country']['data']
                                          ,'json_data' => $order['ship_country']['json_data']
                                          ,'id_selected' => $o['ShipCountry']['id']
                                          ,'selected' => __($o['ShipCountry']['name']));
                           
                if(isset($o['PaymentMethod']['id']))
                $order['pay_metd'] = array('data' => $order['pay_metd']['data']
                                          ,'json_data' => $order['pay_metd']['json_data']
                                          ,'id_selected' => $o['PaymentMethod']['id']
                                          ,'selected' => $o['PaymentMethod']['name']);

                if(isset($o['ShippingMethod']['id']))
                $order['ship_metd'] = array('data' => $order['ship_metd']['data']
                                          ,'json_data' => $order['ship_metd']['json_data']
                                          ,'id_selected' => $o['ShippingMethod']['id']
                                          ,'selected' => $o['ShippingMethod']['name']);
                
                
                
                $this->Session->write('order_edit.order', $order);
            }
            else 
            {
                $this->Session->setFlash(__('Order is not found.', true));
                $this->redirect('/orders_edit/admin/new/');
            }
            
        }
        else
        {
            die();
        }
        
        $this->set('order',$order);
    }
    
    public function change_shipORpay_method ()
    { 
        $order = $this->Session->read('order_edit.order');
        if(isset($order[$this->data['id']]['data'][$this->data['value']]))
        {
            $order[$this->data['id']]['id_selected'] = $this->data['value'];
            $order[$this->data['id']]['selected'] = $order[$this->data['id']]['data'][$this->data['value']];
            $this->set('return',$order[$this->data['id']]['selected']);
            $this->Session->write('order_edit.order', $order);
        }else $this->set('return',null);
        $this->render('/Elements/ajaxreturn');
    }
    
    public function change_country ($key_country, $key_state)
    { 
        $this->loadModel('CountryZone');
        
        $order = $this->Session->read('order_edit.order');
        $order[$key_country]['id_selected'] = $this->data['value'];
        $order[$key_country]['selected'] = $order[$key_country]['data'][$this->data['value']];

        $bill_state = $this->CountryZone->find('list',array('fields' => array('id','name') 
                                                         ,'conditions' => array('country_id' => $this->data['value'])));
        $order[$key_state]['data'] = $bill_state;
        $order[$key_state]['json_data'] = json_encode($bill_state);
 
        $this->set('return',$order[$key_country]['selected']);
        $this->Session->write('order_edit.order', $order);
        $this->render('/Elements/ajaxreturn');
    }

    public function ret_state_data ($key_state)
    {
        $order = $this->Session->read('order_edit.order');
        $this->set('return',$order[$key_state]['json_data']);
        $this->render('/Elements/ajaxreturn');
    }
    
    
    
    public function edit_field ($key_1 = 'nl', $key_2 = 'nl', $key_3 = 'nl')
    {
        $order = $this->Session->read('order_edit.order');
        if($key_1 != 'nl' && $key_2 == 'nl')
        {
            $order[$key_1][$this->data['id']] = $this->data['value'];
        }
        elseif ($key_1 != 'nl' && $key_2 != 'nl' && $key_3 == 'nl')
        {
            $order[$key_1][$key_2][$this->data['id']] = $this->data['value'];
        }
        elseif ($key_1 != 'nl' && $key_2 != 'nl' && $key_3 != 'nl')
        {
            $order[$key_1][$key_2][$key_3] = $this->data['value'];
        }
        else $order[$this->data['id']] = $this->data['value'];
            
        $this->Session->write('order_edit.order', $order);
        $this->set('return',$this->data['value']);

        $this->render('/Elements/ajaxreturn');
    }
    
    public function edit_shipping()
    {
        $order = $this->Session->read('order_edit.order');
        $order['shipping'] = $this->data['value'];
        $this->Session->write('order_edit.order', $order);
        $this->set('return',$this->data['value']);
        $this->render('/Elements/ajaxreturn');
    }

    public function edit_total()
    {
        $order = $this->Session->read('order_edit.order');
        $order['total'] = $this->data['value'];
        $order['total_temp'] = $this->data['value'];
        $this->Session->write('order_edit.order', $order);
        $this->set('return',$this->data['value']);
        $this->render('/Elements/ajaxreturn');
    }
        
    public function admin_add_product ($category = 'group', $id = 0)
    {
		//$this->set('current_crumb', __('Add Product', true));
		$this->set('title_for_layout', __('Add Product', true));

        $order = $this->Session->read('order_edit.order');
                
        $this->loadModel('Content');
        $this->Content->Behaviors->attach('Containable');
        
        $filter = array();
         
        if(isset($this->data['Search']['term']))
        {
            //$id_d = $this->Content->ContentDescription->findAllByName($this->data['Search']['term']);
            $id_d = $this->Content->ContentDescription->find('all',array('conditions' => array('ContentDescription.name LIKE' => '%' . $this->data['Search']['term'] . '%')));
            $id_d = Set::Extract($id_d,'{n}.ContentDescription.content_id');
            if($id_d == null) $id_d = array();
            //$id_p = $this->Content->ContentProduct->findAllByModel($this->data['Search']['term']);
            $id_p = $this->Content->ContentProduct->find('all',array('conditions' => array('ContentProduct.model LIKE' => '%' . $this->data['Search']['term'] . '%')));
            $id_p = Set::Extract($id_p,'{n}.ContentProduct.content_id');
            if($id_p == null) $id_p = array();
            $filter = array('Content.id' => array_merge($id_d,$id_p));

        }
        
        if($category == 'group')
        {
            $this->paginate['Content'] = array('fields' => array('Content.alias')                                         
                                              ,'conditions' => array('Content.content_type_id = 1','Content.show_in_menu = 1',$filter)
                                              ,'limit' => '50'
                                              ,'contain' => array('ContentDescription' => array('conditions' => array('ContentDescription.language_id' => $this->Session->read('Customer.language_id'))),'ContentImage')
                                              );
            $data['content'] = $this->paginate('Content');
            $data['next_category'] = 'product';
            $data['prev_category'] = 'ret';
      
        }
        elseif ($category == 'product') 
        {
            $this->paginate['Content'] = array('fields' => array('Content.alias')
                                              ,'conditions' => array('Content.show_in_menu = 1',$filter,'(Content.parent_id = ' . $id . ' OR '. $id . ' = 0)','Content.content_type_id != 1')
                                              ,'limit' => '50'
                                              ,'contain' => array('ContentDescription' => array('conditions' => array('ContentDescription.language_id' => $this->Session->read('Customer.language_id'))),'ContentImage')
                                              );

            $data['content'] = $this->paginate('Content');

            $data['next_category'] = 'add';
            $data['prev_category'] = 'group';
        }
        elseif ($category == 'add') 
        {
            if(isset($order['OrderProduct']))
            {
                $index = count($order['OrderProduct']);
            }
            else $index = 0;
            

            $this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
            $this->Content->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));            
            $this->Content->recursive = 2;
            if(isset($order['customer_id'])&&$order['customer_id']!=0) $this->Content->ContentProduct->id_customer_discount = $order['customer_id'];            
            $content = $this->Content->find('first',array(
                                                  'conditions' => array('Content.id' => $id)
                                                 ,'contain' => array('ContentProduct','ContentDescription' => array('conditions' => array('ContentDescription.language_id = ' . $this->Session->read('Customer.language_id'))))
                                                 ));
            
            $order['OrderProduct'][$index]['id'] = 'nl';
            $order['OrderProduct'][$index]['order_id'] = $order['id'];
            $order['OrderProduct'][$index]['content_id'] = $content['Content']['id'];
            $order['OrderProduct'][$index]['name'] = $content['ContentDescription']['name'];
            $order['OrderProduct'][$index]['model'] = $content['ContentProduct']['model'];
            $order['OrderProduct'][$index]['sku'] = $content['ContentProduct']['sku'];
            $order['OrderProduct'][$index]['price'] = $content['ContentProduct']['price'];
            $order['OrderProduct'][$index]['quantity'] = '1';
            $order['OrderProduct'][$index]['weight'] = '';
            $order['OrderProduct'][$index]['tax'] = '0';
            $order['OrderProduct'][$index]['filename'] = '';
            $order['OrderProduct'][$index]['filestorename'] = '';
            $order['OrderProduct'][$index]['download_count'] = '0';
            $order['OrderProduct'][$index]['max_downloads'] = '0';
            $order['OrderProduct'][$index]['max_days_for_download'] = '0';
            $order['OrderProduct'][$index]['download_key'] = '0';
            $order['OrderProduct'][$index]['order_status_id'] = '1';

            $order['total'] = $order['tax'] = 0;
            foreach ($order['OrderProduct'] as $value) 
            {
                $order['tax'] += $value['tax'] * $value['quantity'];
                $order['total'] += ($value['price'] * $value['quantity']);
            }
            $order['total'] += $order['tax'] + $order['shipping'];
            
            $this->Session->write('order_edit.order', $order);
            $this->redirect('/orders_edit/admin/redirect/');
        }
        elseif ($category == 'ret') 
        {
            $this->redirect('/orders_edit/admin/redirect/');
        }
        else
        {
            die();
        }

        $this->set('data',$data);
    }
    
    public function admin_delete_product ($index = 0)
    {
        $order = $this->Session->read('order_edit.order');
        
        array_splice($order['OrderProduct'],$index,1);
        if(!empty($order['OrderProduct']))
        {
            $order['total'] = $order['tax'] = 0;
            foreach ($order['OrderProduct'] as $value) 
            {
                $order['tax'] += $value['tax'] * $value['quantity'];
                $order['total'] += ($value['price'] * $value['quantity']);
            }
            $order['total'] += $order['tax'] + $order['shipping'];
        }
        else $order['total'] = 0;
        
        $this->Session->write('order_edit.order', $order);
        $this->redirect('/orders_edit/admin/redirect/');
    }
    
    public function save_order ()
    {
        if(!empty($this->data))
	{
            if(isset($this->data['cancelbutton']))
            {
                $this->redirect('/orders_edit/admin/new/');
                die();
            }
            
            $this->loadModel('Order');
            $this->loadModel('ContentProduct');
            $this->ContentProduct->UnbindAll();
            $order = $this->Session->read('order_edit.order');

            if(!empty($order['total_temp'])) {
            	
            	$order['total'] = $this->Session->read('order_edit.order.total_temp');
            
            } else {

            if(!empty($order['OrderProduct']))
            {    
               $order['total'] = $order['tax'] = 0;
                foreach ($order['OrderProduct'] as $value) 
                {
                    $order['tax'] += $value['tax'] * $value['quantity'];
                    $order['total'] += ($value['price'] * $value['quantity']);
                }
                $order['total'] += $order['tax'] + $order['shipping'];
            }
            
            }
            
            //if (null !== $this->Session->read('order_edit.order.total_temp')) $order['total'] = $this->Session->read('order_edit.order.total');

            $temp_order = array('Order' => array( 'id' => $order['id']
                            ,'order_status_id' => '1'
                            ,'shipping_method_id' => $order['ship_metd']['id_selected']
                            ,'payment_method_id' => $order['pay_metd']['id_selected']
                            ,'shipping' => $order['shipping']
                            ,'tax' => $order['tax']
                            ,'total' => $order['total']
                            ,'bill_name' => $order['bill_inf']['Customer_Name']
                            ,'bill_line_1' => $order['bill_inf']['Address_Line_1']
                            ,'bill_line_2' => $order['bill_inf']['Address_Line_2']
                            ,'bill_city' => $order['bill_inf']['City']
                            ,'bill_state' => $order['bill_state']['id_selected']
                            ,'bill_country' => $order['bill_country']['id_selected']
                            ,'bill_zip' => $order['bill_inf']['Zip']
                            ,'ship_name' => $order['ship_inf']['Ship_Customer_Name']
                            ,'ship_line_1' => $order['ship_inf']['Ship_Address_Line_1']
                            ,'ship_line_2' => $order['ship_inf']['Ship_Address_Line_2']
                            ,'ship_city' => $order['ship_inf']['Ship_City']
                            ,'ship_state' => $order['ship_state']['id_selected']
                            ,'ship_country' => $order['ship_country']['id_selected']
                            ,'ship_zip' => $order['ship_inf']['Ship_Zip']
                            ,'email' => $order['contact_inf']['Email']
                            ,'phone' => $order['contact_inf']['Phone']
                            ,'company_name' => $order['contact_inf']['Company']
                            ,'company_info' => ''
                            ,'company_vat' => null
                            ,'created' => date("Y-m-d H:i:s")
                    ));

           $max_id = $this->Order->OrderProduct->find('first',array('fields' => array('MAX(OrderProduct.id) as id')));
           $max_id = $max_id[0]['id'];
           foreach ($order['OrderProduct'] AS $k => $orderproduct)
           {
                    if($orderproduct['id'] == 'nl'){ $max_id++; $id = $max_id;} else $id = $orderproduct['id'];
                    $temp_order_product[$k] = array('OrderProduct' => array('id' => $id
                               ,'order_id' => $order['id']
                               ,'content_id' => $orderproduct['content_id']
                               ,'name' => $orderproduct['name']
                               ,'model' => $orderproduct['model']
                               ,'sku' => $orderproduct['sku']
                               ,'quantity' => $orderproduct['quantity']
                               ,'price' => $orderproduct['price']
                               ,'weight' => $orderproduct['weight']
                               ,'tax' => $orderproduct['tax']
                               ,'filename' => $orderproduct['filename']
                               ,'filestorename' => $orderproduct['filestorename']
                               ,'download_count' => $orderproduct['download_count']
                               ,'max_downloads' => $orderproduct['max_downloads']
                               ,'max_days_for_download' => $orderproduct['max_days_for_download']
                               ,'download_key' => $orderproduct['download_key']
                               ,'order_status_id' => $orderproduct['order_status_id']
                        ));
                    
                    $save_order = $this->Order->OrderProduct->find('first',array('fields' => array('OrderProduct.quantity')
                                                        ,'conditions' => array('OrderProduct.id'=> $id, 'OrderProduct.order_id' => $order['id']/*,'OrderProduct.quantity <>' => $orderproduct['quantity']*/)));
                    if(!empty($save_order) && $save_order['OrderProduct']['quantity'] != $orderproduct['quantity'])
                    {
                        $temp_order_product[$k]['rotate_product'] = $orderproduct['quantity'] - $save_order['OrderProduct']['quantity'];
                    } elseif(!empty($save_order) && $save_order['OrderProduct']['quantity'] == $orderproduct['quantity'])  
                        $temp_order_product[$k]['rotate_product'] = 0;                                                   
                    else $temp_order_product[$k]['rotate_product'] = $orderproduct['quantity'];
            }
            
            $list_id = 0;
            if(!empty($temp_order_product))
            {
                $list_id = Set::Extract($temp_order_product,'{n}.OrderProduct.id');

                foreach ($temp_order_product AS $k => $orderproduct)
                {
                    $this->Order->OrderProduct->save(array('OrderProduct' => $orderproduct['OrderProduct']));    
                    
                    $content = $this->ContentProduct->find('first',array('conditions' => array('ContentProduct.content_id' => $orderproduct['OrderProduct']['content_id'])));
                    $this->ContentProduct->updateAll(array('ContentProduct.stock' => $content['ContentProduct']['stock'] - $orderproduct['rotate_product'])
                                                    ,array('ContentProduct.content_id' => $orderproduct['OrderProduct']['content_id']));
                }

                $del_id = $this->Order->OrderProduct->find('all',array('fields' => array('OrderProduct.id')
                                                            ,'conditions' => array('OrderProduct.id NOT' => $list_id, 'OrderProduct.order_id=' . $order['id'])
                                                            ));
                $del_id = Set::Extract($del_id,'{n}.OrderProduct.id');
                if(!empty($del_id))
                {
                    foreach ($del_id as $id) 
                    {
                      
                      $orderproduct = $this->Order->OrderProduct->find('first',array('fields' => array('OrderProduct.content_id','OrderProduct.quantity')
                                                                                    ,'conditions' => array('OrderProduct.id' => $id)));
                      
                      $content = $this->ContentProduct->find('first',array('conditions' => array('ContentProduct.content_id' => $orderproduct['OrderProduct']['content_id'])));
                      $this->ContentProduct->updateAll(array('ContentProduct.stock' => $content['ContentProduct']['stock'] + $orderproduct['OrderProduct']['quantity'])
                                                        ,array('ContentProduct.id' => $content['ContentProduct']['id']));
                      $this->Order->OrderProduct->delete($id);

                    }
                }
            }  

            if($this->Order->save($temp_order))
            {
                $msg = __('Order saved!');
            } else $msg = __('Order not saved!');
            $this->Session->write('order_edit.order', $order);     
            $this->Session->delete('order_edit.order.total_temp');     
            $this->Session->setFlash($msg);
            $this->redirect('/orders_edit/admin/redirect/');
        }

    }
   
}
?>