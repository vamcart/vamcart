<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class TaxesController extends AppController {
	public $name = 'Taxes';
	public $uses = 'Tax';
	
	public function admin_set_all_products ($tax_id) 
	{
		$products = $this->Tax->ContentProduct->find('all');
		
		foreach($products AS $product)
		{
			$product['ContentProduct']['tax_id'] = $tax_id;
			$this->Tax->ContentProduct->save($product);
		}
	
		$this->Session->setFlash(__('You have updated multiple records.',true));				
		$this->redirect('/taxes/admin/');
	}
	

	public function admin_set_as_default ($id)
	{
		$this->setDefaultItem($id);
	}
	
	public function admin_delete ($id)	
	{
		$this->Session->setFlash(__('Record deleted.',true));	
		$this->Tax->delete($id);
		$this->redirect('/taxes/admin/');
	}
		
	public function admin_edit ($id = null)
	{
		$this->set('current_crumb', __('Tax', true));
		$this->set('title_for_layout', __('Tax', true));
		if(empty($this->data))
		{
			$this->request->data = $this->Tax->read(null,$id);
		}
		else
		{
			// If they pressed cancel
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/taxes/admin/');
				die();
			}
			
			$this->Tax->save($this->data);
			$this->Session->setFlash(__('Record created.',true));				
			$this->redirect('/taxes/admin/');
		}
	}
	
	public function admin_new ()
	{
		$this->redirect('/taxes/admin_edit/');
	}
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Taxes Listing', true));
		$this->set('title_for_layout', __('Taxes Listing', true));
		$this->set('tax_data',$this->Tax->find('all', array('order' => array('Tax.name ASC'))));

	}	
}
?>