<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class PaymentMethodsController extends AppController {
	var $name = 'PaymentMethods';

	function admin_set_as_default ($id)
	{
		$this->setDefaultItem($id);
	}
	
	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		

	function admin_edit ($id)
	{
		$this->set('current_crumb', __('Edit Payment Method', true));
		if(empty($this->data))
		{
			$this->set('data',$this->PaymentMethod->read(null,$id));
			$this->render('','admin');
		}
		else
		{
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/payment_methods/admin/');
				die();
			}

			// Save the main payment information
			$this->PaymentMethod->save($this->data);
			
			// Loop through the extra and save the the PaymentMethodValue table
			$payment = $this->PaymentMethod->read(null,$id);
			$type_key = $payment['PaymentMethod']['alias'];
			
			foreach($this->data[$type_key] AS $key => $value)
			{
				$original_value = $this->PaymentMethod->PaymentMethodValue->find(array('key' => $key,'payment_method_id' => $id));
				$original_value['PaymentMethodValue']['payment_method_id'] = $id;
				$original_value['PaymentMethodValue']['key'] = $key;
				$original_value['PaymentMethodValue']['value'] = $value;				

				$this->PaymentMethod->PaymentMethodValue->save($original_value);
			}
			
			$this->Session->setFlash(__('Record saved.',true));
			$this->redirect('/payment_methods/admin/');
		}
	
	}	
		
	function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Payment Methods Listing', true));
		$this->set('payment_method_data',$this->PaymentMethod->findAll(null,null,'PaymentMethod.name ASC'));	

		if($ajax == true)
			$this->render('','ajax');
		else
			$this->render('','admin');
	}	


}
?>