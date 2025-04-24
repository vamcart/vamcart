<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
   
App::uses('Model', 'AppModel');
class ContentDownloadable extends AppModel {
	public $name = 'ContentDownloadable';
	public $belongsTo = array('Tax');
	public $hasMany = array('ContentProductPrice' => array('dependent' => true,'foreignKey' => 'content_product_id'));

	public $validate = array(
		'price' => array(
			'rule' => 'notBlank'
		)
	);

        public $id_customer_discount = null;
        public $is_discount = true;  
        
        public function setDiscount($is_discount = true)
        {
           $this->is_discount = $is_discount;
        }        
        
        public function afterFind($results, $primary = false)
        {
            if($this->is_discount)
            foreach ($results as $key => $value) 
            {
                $price = null;
                if(isset($results[$key]['ContentDownloadable']['content_id']))
                {
                    $price = $this->getPriceModificator($value['ContentDownloadable']['content_id'] ,$results[$key]['ContentDownloadable']['price']);
                    $id_customer = null;
                    if(isset($_SESSION['Customer']['customer_id'])) $id_customer = $_SESSION['Customer']['customer_id'];
                    else if(isset($this->id_customer_discount)) $id_customer = $this->id_customer_discount;
                    if(isset($id_customer))
                    {
                        App::import('Model', 'Customer');
                        $Customer = new Customer();
                        $discount_group = $Customer->find('first',array('conditions' => array('Customer.id' => $id_customer)));
                        if(isset($discount_group['GroupsCustomer']['price'])) $price = $price - ($price * $discount_group['GroupsCustomer']['price'] / 100);
                    } 
                    $results[$key]['ContentDownloadable']['price'] = $price;
                }
            // Get special price
                (isset($results[$key]['ContentDownloadable']['content_id'])) ? $results[$key]['ContentDownloadable']['old_price'] = $results[$key]['ContentDownloadable']['price'] : null;
                if(isset($results[$key]['ContentDownloadable']['content_id']) && $results[$key]['ContentDownloadable']['price'] > 0)
                {
                        App::import('Model', 'ContentSpecial');
                        $Special = new ContentSpecial();
                        $special_price = $Special->find('first',array('conditions' => array('ContentSpecial.content_id' => $value['ContentDownloadable']['content_id'])));

                        if($special_price) {
                        if($special_price['ContentSpecial']['price'] > 0) { 
                        if((isset($special_price['ContentSpecial']['date_start']) && time() >= strtotime($special_price['ContentSpecial']['date_start'])) or !isset($special_price['ContentSpecial']['date_start'])) { 
                        if(isset($special_price['ContentSpecial']['date_end']) && time() <= strtotime($special_price['ContentSpecial']['date_end']) or !isset($special_price['ContentSpecial']['date_end'])) { 
                        $price = $special_price['ContentSpecial']['price'];
                     	}
                     	}
                     	}
                     	}

                    $results[$key]['ContentDownloadable']['price'] = $price;
                }
            }

            return($results);
        }
        
        public function getPriceModificator($content_id, $price = 0)
        {
            App::import('Model', 'Attr');
            $Attribute = new Attr();
            $Attribute->unbindAll();
            $parent_attrs = $Attribute->find('list',array('fields' => 'Attr.parent_id'
                                                 ,'conditions' => array('Attr.content_id' => $content_id, 'Attr.val != 0' , 'Attr.val is not null')
                                                 ,'order' => array('Attr.order ASC')));
            $Attribute->unbindAll();
            $attrs = $Attribute->find('all',array('fields' => array('Attr.parent_id','Attr.price_modificator','Attr.price_value')
                                                 ,'conditions' => array('Attr.id' => $parent_attrs)
                                                 ,'order' => array('Attr.order ASC')));
            foreach($attrs as $k => $attr)
            {
                if(is_numeric($attr['Attr']['price_value']))
                {
                    switch ($attr['Attr']['price_modificator']) 
                    {
                        case '=':
                            $price = $attr['Attr']['price_value'];
                        break;
                        case '+':
                            $price = $price + $attr['Attr']['price_value'];
                        break;
                        case '-':
                            $price = $price - $attr['Attr']['price_value'];
                        break;
                        case '*':
                            $price = $price * $attr['Attr']['price_value'];
                        break;
                        case '/':
                             $price = $price / $attr['Attr']['price_value'];
                        break;               
                        default:
                        break;
                    }
                }
            }
            $price = number_format($price, 2, '.', '');
            return $price;
        }

}