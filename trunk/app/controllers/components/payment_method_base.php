<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class PaymentMethodBaseComponent extends Object 
{

	function beforeFilter ()
	{
	}

    function startup(&$controller)
	{
    }
	
	function save_customer_data()
	{
		App::import('Component', 'CustomerBase');		
		$this->CustomerBase =& new CustomerBaseComponent();
		$this->CustomerBase->save_customer_details($_POST);

		App::import('Component', 'OrderBase');		
		$this->OrderBase =& new OrderBaseComponent();		
		
		$this->OrderBase->update_order_totals();
	}
	
}
?>