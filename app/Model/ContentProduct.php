<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
   
App::uses('Model', 'AppModel');
class ContentProduct extends AppModel {
	public $name = 'ContentProduct';
	public $belongsTo = array('Tax');
	public $hasMany = array('ContentProductPrice' => array('dependent' => true));
	
	public $validate = array(
	'price' => array(
		'rule' => 'notEmpty'
	),
	'weight' => array(
		'rule' => 'notEmpty'
	),
	'stock' => array(
		'rule' => 'notEmpty'
	)
	);
        
        public $id_customer_discount = null;
        
        public function afterFind($results, $primary = false)
        {
            foreach ($results as $key => $value) 
            {
                $price = null;
                if(isset($results[$key]['ContentProduct']['content_id']))
                {
                    $price = $this->getPriceModificator($value['ContentProduct']['content_id'] ,$results[$key]['ContentProduct']['price']);
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
                    $results[$key]['ContentProduct']['price'] = $price;
                }
            }

            return($results);
        }
        
        public function getPriceModificator($content_id, $price = 0)
        {
            App::import('Model', 'Attribute');
            $Attribute = new Attribute();
            $Attribute->unbindAll();
            $parent_attrs = $Attribute->find('list',array('fields' => 'Attribute.parent_id'
                                                 ,'conditions' => array('Attribute.content_id' => $content_id, 'Attribute.val != 0' , 'Attribute.val is not null')
                                                 ,'order' => array('Attribute.order ASC')));
            $Attribute->unbindAll();
            $attrs = $Attribute->find('all',array('fields' => array('Attribute.parent_id','Attribute.price_modificator','Attribute.price_value')
                                                 ,'conditions' => array('Attribute.id' => $parent_attrs)
                                                 ,'order' => array('Attribute.order ASC')));
            foreach($attrs as $k => $attr)
            {
                if(is_numeric($attr['Attribute']['price_value']))
                {
                    switch ($attr['Attribute']['price_modificator']) 
                    {
                        case '=':
                            $price = $attr['Attribute']['price_value'];
                        break;
                        case '+':
                            $price = $price + $attr['Attribute']['price_value'];
                        break;
                        case '-':
                            $price = $price - $attr['Attribute']['price_value'];
                        break;
                        case '*':
                            $price = $price * $attr['Attribute']['price_value'];
                        break;
                        case '/':
                             $price = $price / $attr['Attribute']['price_value'];
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
?>