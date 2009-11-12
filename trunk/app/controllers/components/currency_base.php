<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class CurrencyBaseComponent extends Object 
{

	function beforeFilter ()
	{
		
	}

    function startup(&$controller)
	{
    }


	function display_price ($price)
	{
		// Start Cache
		$currency = Cache::read('vam_currency_' . $_SESSION['Customer']['currency_id']);
		if($currency === false)
		{
		
			App::import('Model', 'Currency');
				$this->Currency =& new Currency();
	
			$currency = $this->Currency->read(null, $_SESSION['Customer']['currency_id']);

			Cache::write('vam_currency_' . $_SESSION['Customer']['currency_id'], $currency);
		}

		$price = $price * $currency['Currency']['value'];
		$price = number_format($price,$currency['Currency']['decimal_places'],$currency['Currency']['decimal_point'],$currency['Currency']['thousands_point']);
		$price = $currency['Currency']['symbol_left'] . ' ' . $price . ' ' . $currency['Currency']['symbol_right'];
		return $price;
	}


	
	
}
?>