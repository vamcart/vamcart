<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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