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

class AdminController extends PaymentAppController {
	var $uses = null;
	
	function edit($id)
	{
		App::import('Model', 'PaymentMethod');
		$this->PaymentMethod =& new PaymentMethod();
		
		$method = $this->PaymentMethod->read(null,$id);
		
		$data = $this->PaymentMethod->PaymentMethodValue->find('all', array('conditions' => array('payment_method_id' => $id)));
		
		$keyed_array = array();
		if(!empty($data))
			$keyed_array = array_combine(Set::extract($data, '{n}.PaymentMethodValue.key'),
							 		 Set::extract($data, '{n}.PaymentMethodValue'));		
				
		$this->set('data',$keyed_array);
	}
	
}
?>