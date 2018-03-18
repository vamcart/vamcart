<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class CurrencyBaseComponent extends CakeObject 
{

	public function beforeFilter ()
	{
	}

   public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}
	
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller, $url, $status = NULL, $exit = true){
	}

	public function display_price ($price)
	{
		// Start Cache
		$currency = Cache::read('vam_currency_' . $_SESSION['Customer']['currency_id'], 'catalog');
		if($currency === false)
		{
		
			App::import('Model', 'Currency');
			$Currency = new Currency();
	
			$currency = $Currency->read(null, $_SESSION['Customer']['currency_id']);

			Cache::write('vam_currency_' . $_SESSION['Customer']['currency_id'], $currency, 'catalog');
		}

		$price = $price * $currency['Currency']['value'];
		$price = number_format($price,$currency['Currency']['decimal_places'],$currency['Currency']['decimal_point'],$currency['Currency']['thousands_point']);
		$price = $currency['Currency']['symbol_left'] . ' ' . $price . ' ' . $currency['Currency']['symbol_right'];
		return $price;
	}


	
	
}
?>