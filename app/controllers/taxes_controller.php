<?php
class TaxesController extends AppController {
	var $name = 'Taxes';
	
	function admin_set_all_products ($tax_id) 
	{
		$products = $this->Tax->ContentProduct->findAll();
		
		foreach($products AS $product)
		{
			$product['ContentProduct']['tax_id'] = $tax_id;
			$this->Tax->ContentProduct->save($product);
		}
	
		$this->Session->setFlash(__('record_multiple_saved',true));				
		$this->redirect('/taxes/admin/');
	}
	

	function admin_set_as_default ($id)
	{
		$this->setDefaultItem($id);
	}
	
	function admin_delete ($id)	
	{
		$this->Session->setFlash(__('record_deleted',true));	
		$this->Tax->del($id);
	}
		
	function admin_edit ($id = null)
	{
		if(empty($this->data))
		{
			$this->data = $this->Tax->read(null,$id);
			$this->render('','admin');		
		}
		else
		{
			// If they pressed cancel
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/taxes/admin/');
				die();
			}
			
			$this->Tax->save($this->data);
			$this->Session->setFlash(__('record_created',true));				
			$this->redirect('/taxes/admin/');
		}
	}
	
	function admin_new ()
	{
		$this->redirect('/taxes/admin_edit/');
	}
	
	function admin ($ajax = false)
	{
			
		$this->set('tax_data',$this->Tax->findAll(null,null,'Tax.name ASC'));	

		if($ajax == true)
			$this->render('','ajax');
		else
			$this->render('','admin');
	}	
}
?>