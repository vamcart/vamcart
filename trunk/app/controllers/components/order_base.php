<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class OrderBaseComponent extends Object 
{

    function startup(&$controller)
	{

    }

	function load_models()
	{
		loadComponent('ContentBase');
			$this->ContentBase =& new ContentBaseComponent();
		
		loadModel('Content');
			$this->Content =& new Content();
		
		loadModel('ContentDescription');
			$this->ContentDescription =& new ContentDescription();		
		
		loadModel('Order');
			$this->Order =& new Order();
					
	}
	
	function get_order ($order_id = null)
	{
		if(($order_id == null)&&(isset($_SESSION['Customer']['order_id'])))
			$order_id = $_SESSION['Customer']['order_id'];
		
		$this->load_models();
		
		if($order_id != null)
		{
			$this->Order->unbindModel(array('belongsTo' => array('OrderStatus')));
			$this->Order->unbindModel(array('hasMany' => array('OrderComment')));			
			$order = $this->Order->find(array('Order.id' => $order_id),null,null,2);
		}
		else
		{
			$order = array();
		}

		return $order;
	}
	
	function get_order_shipping (&$order)
	{

		if(!isset($order['ShippingMethod']['code']))
			return 0;
		
		$shipping_component = Inflector::classify($order['ShippingMethod']['code']);
		$shipping_component2 =  Inflector::classify($order['ShippingMethod']['code']) . 'Component';
		loadPluginComponent('shipping',$shipping_component);
		$this->MethodBase =& new $shipping_component2();
		
		$shipping_total = $this->MethodBase->calculate();

		return $shipping_total;
		
	}
	
	function get_order_tax (&$order)
	{
		$running_total = 0;	

		foreach($order['OrderProduct'] AS $product)
		{
			$running_total += ($product['quantity'] * $product['tax']);
		}
		
		return $running_total;		

	}

	function get_order_total (&$order)
	{
		$running_total = 0;	
			
		foreach($order['OrderProduct'] AS $product)
		{
			$running_total += ($product['quantity'] * $product['price']);
		}
		
		return $running_total;		
	}
	
	function update_order_totals ()
	{
		$this->load_models();
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$order['Order']['shipping'] = $this->get_order_shipping($order);
		$order['Order']['tax'] = $this->get_order_tax($order);
		$order['Order']['total'] = $this->get_order_total($order) + $order['Order']['tax'] + $order['Order']['shipping'] ;
		
		loadComponent('EventBase');
		$this->EventBase =& new EventBaseComponent();
		
		$this->EventBase->ProcessEvent('UpdateOrderTotalsBeforeSave');
		$this->Order->save($order);	
		$this->EventBase->ProcessEvent('UpdateOrderTotalsAfterSave');		
	}
	
	function remove_product ($product_id, $qty=1)
	{
		$this->load_models();
		
		$order_product = $this->Order->OrderProduct->find(array('content_id' => $product_id,'order_id' => $_SESSION['Customer']['order_id']));	
		
		loadComponent('EventBase');
		$this->EventBase =& new EventBaseComponent();
		
		$this->EventBase->ProcessEvent('RemoveFromCartBeforeSave');		
		if($order_product['OrderProduct']['quantity'] <= $qty)
		{
			$this->Order->OrderProduct->del($order_product['OrderProduct']['id']);
		}
		else
		{
			$order_product['OrderProduct']['quantity'] -= $qty;
			$this->Order->OrderProduct->save($order_product);
		}
		$this->EventBase->ProcessEvent('RemoveFromCartAfterSave');
		
		$this->update_order_totals();
	}

	function add_product ($content_id,$qty=1)
	{
		$this->load_models();
		$content = $this->ContentBase->get_content_information($content_id);
		
		$content_description = $this->ContentBase->get_content_description($content_id);
		$content['ContentDescription'] = $content_description['ContentDescription'];

		$product = $this->Order->OrderProduct->Content->find(array('Content.id' => $content_id));
		
		// Get the product from the OrderProduct model...	
		$order_product = $this->Order->OrderProduct->find(array('order_id' => $_SESSION['Customer']['order_id'], 'content_id' => $content_id));

		if(empty($order_product))
		{

			$order_product = array('order_id' => $_SESSION['Customer']['order_id'],
							 'content_id' => $content_id,
							 'name' => $content['ContentDescription']['name'],
							 'quantity' => $qty,
							 'price' => $product['ContentProduct']['price'],
							 'weight' => $product['ContentProduct']['weight']);
		}
		else
		{
			$order_product['OrderProduct']['quantity'] += abs($qty);
		}

		loadComponent('EventBase');
		$this->EventBase =& new EventBaseComponent();
		
		$this->EventBase->ProcessEvent('AddToCartBeforeSave');
		$this->Order->OrderProduct->save($order_product);
		$this->EventBase->ProcessEvent('AddToCartAfterSave');
				
		$this->update_order_totals();
			
	}	

	
}
?>