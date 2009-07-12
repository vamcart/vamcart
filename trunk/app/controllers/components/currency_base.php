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
		$currency = Cache::read('sms_currency_' . $_SESSION['Customer']['currency_id']);
		if($currency === false)
		{
		
			loadModel('Currency');
				$this->Currency =& new Currency();
	
			$currency = $this->Currency->read(null, $_SESSION['Customer']['currency_id']);

			Cache::write('sms_currency_' . $_SESSION['Customer']['currency_id'], $currency);
		}

		$price = $price * $currency['Currency']['value'];
		$price = number_format($price,$currency['Currency']['decimal_places'],$currency['Currency']['decimal_point'],$currency['Currency']['thousands_point']);
		$price = $currency['Currency']['symbol_left'] . $price . $currency['Currency']['symbol_right'];
		return $price;
	}


	
	
}
?>