<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentProduct extends AppModel {
	public $name = 'ContentProduct';
	public $belongsTo = array('Tax');
	
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
        
        	
        public function afterFind($results, $primary = false)
        {
           if(isset($results['content_id'])) $results['price'] = 2;
           else
            foreach ($results as $key => $value) 
            {
                 if(isset($results[$key]['ContentProduct']['content_id']))
                 {
                     $results[$key]['ContentProduct']['price'] = $this->getPriceModificator($value['ContentProduct']['content_id'] ,$results[$key]['ContentProduct']['price']);
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