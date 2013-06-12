<?php

class OrdersUnController extends AppController 
{
    public $name = 'OrdersUn';
    public $paginate = null;
    
    
    public function admin ($act = 'new', $id = 0)
    {
        $order = array( 'id' => 0
                       ,'bill_inf' => array());
        
        if($act == 'new')
        {
            $this->loadModel('Order');
            $this->Order->unbindAll();
            $max_id = $this->Order->find('first',array('fields' => array('MAX(Order.id) as id')));
            $order['id'] = $max_id[0]['id'] + 1;
            $order['bill_inf'] = array('Customer_Name' => '','Address_Line_1' => '','Address_Line_2' => '','City' => '','State' => '','Country' => '','Zip' => '');
            $order['ship_inf'] = array('_Customer_Name' => '','_Address_Line_1' => '','_Address_Line_2' => '','_City' => '','_State' => '','_Country' => '','_Zip' => '');
            $order['contact_inf'] = array('Email' => '','Phone' => '','Company' => '0');
            $order['pay_inf'] = array('Credit_Card' => '0','Expiration' => '0');
            $order['total'] = 0;
            
            $this->Session->write('OrdersUn.order', $order);
        }
        elseif ($act == 'redirect') 
        {
            $order = $this->Session->read('OrdersUn.order');
        }
        elseif ($act == 'edit') 
        {
            $this->loadModel('Order');
            $this->Order->Behaviors->attach('Containable');
            $o = $this->Order->find('all',array('fields' => array('Order.*')
                                                       ,'conditions' => array('Order.id = '.$id)
                                                       ,'order' => 'id DESC LIMIT 1'
                                                       ,'contain' => array('OrderProduct')
                                                                ));
            if(isset($o[0]['Order']))
            {
                $order['id'] = $id;
                $order['bill_inf'] = array('Customer_Name' => $o[0]['Order']['bill_name']
                                          ,'Address_Line_1' => $o[0]['Order']['bill_line_1']
                                          ,'Address_Line_2' => $o[0]['Order']['bill_line_2']
                                          ,'City' => $o[0]['Order']['bill_city']
                                          ,'State' => $o[0]['Order']['bill_state']
                                          ,'Country' => $o[0]['Order']['bill_country']
                                          ,'Zip' => $o[0]['Order']['bill_zip']
                                          );

                $order['ship_inf'] = array('_Customer_Name' => $o[0]['Order']['ship_name']
                                          ,'_Address_Line_1' => $o[0]['Order']['ship_line_1']
                                          ,'_Address_Line_2' => $o[0]['Order']['ship_line_2']
                                          ,'_City' => $o[0]['Order']['ship_city']
                                          ,'_State' => $o[0]['Order']['ship_state']
                                          ,'_Country' => $o[0]['Order']['ship_country']
                                          ,'_Zip' => $o[0]['Order']['ship_zip']
                                          );
                $order['contact_inf'] = array('Email' => $o[0]['Order']['email']
                                             ,'Phone' => $o[0]['Order']['phone']
                                             ,'Company' => $o[0]['Order']['company_name']
                                             );
                $order['pay_inf'] = array('Credit_Card' => $o[0]['Order']['cc_number']
                                         ,'Expiration' => $o[0]['Order']['cc_expiration_month']
                                         );
                    
                $order['OrderProduct'] = $o[0]['OrderProduct'];
                $order['total'] = $o[0]['Order']['total'];
                
                $this->Session->write('OrdersUn.order', $order);
            }
            else 
            {
                $this->Session->setFlash(__('Record not found!', true));
                $this->redirect('/orders_un/admin/new/');
            }
            
        }
        else
        {
            die();
        }
        
        $this->set('order',$order);
    }
    
    public function edit_field ($key_1 = 'nl', $key_2 = 'nl', $key_3 = 'nl')
    {
        /*if ($this->RequestHandler->isAjax()) 
        {
            $this->layout = 'ajax_empty';
        }*/ 
        $order = $this->Session->read('OrdersUn.order');
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
            
        $this->Session->write('OrdersUn.order', $order);
        $this->set('return',$this->data['value']);

        $this->render('/Elements/ajaxreturn');
    }
        
    public function admin_add_product ($category = 'group', $id = 1)
    {
        $this->loadModel('Content');
        //$this->Content->recursive = 2;
        $this->Content->Behaviors->attach('Containable');
        
        if($category == 'group')
        {
          
            $this->paginate['Content'] = array('fields' => array('Content.alias')
                                              ,'conditions' => array('Content.content_type_id = 1','Content.show_in_menu = 1')
                                              ,'limit' => '50'
                                              ,'contain' => array('ContentDescription' => array('conditions' => array('ContentDescription.language_id = ' . $this->Session->read('Customer.language_id'))),'ContentImage')
                                              );
            $data['content'] = $this->paginate('Content');
            $data['category'] = 'product';
      
        }
        elseif ($category == 'product') 
        {
            $this->paginate['Content'] = array('fields' => array('Content.alias')
                                              ,'conditions' => array('Content.parent_id = ' . $id,'Content.show_in_menu = 1')
                                              ,'limit' => '50'
                                              ,'contain' => array('ContentDescription' => array('conditions' => array('ContentDescription.language_id = ' . $this->Session->read('Customer.language_id'))),'ContentImage')
                                              );
            $data['content'] = $this->paginate('Content');
            $data['category'] = 'add';
        }
        elseif ($category == 'add') 
        {
            $order = $this->Session->read('OrdersUn.order');
            
            if(isset($order['OrderProduct']))
            {
                $index = count($order['OrderProduct']);
            }
            else $index = 0;
            
            $this->Content->recursive = 2;
            $content = $this->Content->find('all',array(
                                                  'conditions' => array('Content.id = ' . $id)
                                                 ,'limit' => '1'
                                                 ,'contain' => array('ContentProduct','ContentDescription' => array('conditions' => array('ContentDescription.language_id = ' . $this->Session->read('Customer.language_id'))))
                                                 ));

            $order['OrderProduct'][$index]['id'] = 'nl';
            $order['OrderProduct'][$index]['order_id'] = $content[0]['Content']['id'];
            $order['OrderProduct'][$index]['name'] = $content[0]['ContentDescription'][0]['name'];
            $order['OrderProduct'][$index]['model'] = $content[0]['ContentProduct']['model'];
            $order['OrderProduct'][$index]['price'] = $content[0]['ContentProduct']['price'];
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
            
            //$order['total'] = round(array_sum(Set::Extract($order['OrderProduct'],'{n}.price')),2);
            $order['total'] = 0;
            foreach ($order['OrderProduct'] as $value) 
            {
                $order['total'] += $value['price'] * $value['quantity'];
            }
            
            $this->Session->write('OrdersUn.order', $order);
            $this->redirect('/orders_un/admin/redirect/');
        }
        else
        {
            die();
        }

        $this->set('data',$data);
    }
    
    public function admin_delete_product ($index = 0)
    {
        $order = $this->Session->read('OrdersUn.order');
        
        //unset($order['OrderProduct'][$index]);
        array_splice($order['OrderProduct'],$index,1);
        if(!empty($order['OrderProduct']))
        {
            //$order['total'] = round(array_sum(Set::Extract($order['OrderProduct'],'{n}.price')),2);
            $order['total'] = 0;
            foreach ($order['OrderProduct'] as $value) 
            {
                $order['total'] += $value['price'] * $value['quantity'];
            }
        }
        else $order['total'] = 0;
        
        $this->Session->write('OrdersUn.order', $order);
        $this->redirect('/orders_un/admin/redirect/');
    }
    
    public function save_order ()
    {
        if(!empty($this->data))
	{
            if(isset($this->data['cancelbutton']))
            {
                $this->redirect('/orders_un/admin/new/');
                die();
            }
            
            $this->loadModel('Order');
            $order = $this->Session->read('OrdersUn.order');
            
            $order['total'] = 0;
            foreach ($order['OrderProduct'] as $value) 
            {
                $order['total'] += $value['price'] * $value['quantity'];
            }
            
            $temp_order = array('Order' => array( 'id' => $order['id']
                            ,'order_status_id' => '1'
                            ,'shipping_method_id' => '0'
                            ,'payment_method_id' => '0'
                            ,'shipping' => '0'
                            ,'tax' => '0'
                            ,'total' => $order['total']
                            ,'bill_name' => $order['bill_inf']['Customer_Name']
                            ,'bill_line_1' => $order['bill_inf']['Address_Line_1']
                            ,'bill_line_2' => $order['bill_inf']['Address_Line_2']
                            ,'bill_city' => $order['bill_inf']['City']
                            ,'bill_state' => $order['bill_inf']['State']
                            ,'bill_country' => $order['bill_inf']['Country']
                            ,'bill_zip' => $order['bill_inf']['Zip']
                            ,'ship_name' => $order['ship_inf']['_Customer_Name']
                            ,'ship_line_1' => $order['ship_inf']['_Address_Line_1']
                            ,'ship_line_2' => $order['ship_inf']['_Address_Line_2']
                            ,'ship_city' => $order['ship_inf']['_City']
                            ,'ship_state' => $order['ship_inf']['_State']
                            ,'ship_country' => $order['ship_inf']['_Country']
                            ,'ship_zip' => $order['ship_inf']['_Zip']
                            ,'email' => $order['contact_inf']['Email']
                            ,'phone' => $order['contact_inf']['Phone']
                            ,'cc_number' => $order['pay_inf']['Credit_Card']
                            ,'cc_expiration_month' => $order['pay_inf']['Expiration']
                            ,'cc_expiration_year' => '1'
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
                               ,'content_id' => $orderproduct['order_id']
                               ,'name' => $orderproduct['name']
                               ,'model' => $orderproduct['model']
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
            }
            
            $msg = null;
            $add_id = 0;
            if(!empty($temp_order_product))
            {
                foreach ($temp_order_product AS $orderproduct)
                {
                    $this->Order->OrderProduct->save($orderproduct);
                }
                $add_id = Set::Extract($temp_order_product,'{n}.OrderProduct.id');
            }
            

            $del_id = $this->Order->OrderProduct->find('all',array('fields' => array('OrderProduct.id')
                                                        ,'conditions' => array('OrderProduct.id NOT' => $add_id, 'OrderProduct.order_id=' . $order['id'])
                                                        ));
            $del_id = Set::Extract($del_id,'{n}.OrderProduct.id');
            if(!empty($del_id))
            {
                foreach ($del_id as $id) 
                {
                  $this->Order->OrderProduct->delete($id);
                }
            }

            if($this->Order->save($temp_order))
            {
                $msg = __('Order saved.');
            } else $msg = __('Order not saved!');
            $this->Session->write('OrdersUn.order', $order);     
            $this->Session->setFlash($msg);
            $this->redirect('/orders_un/admin/redirect/');
        }

    }
}
?>