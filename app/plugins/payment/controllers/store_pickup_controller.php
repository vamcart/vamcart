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

class StorePickupController extends PaymentAppController {
	var $uses = null;

	function settings ()
	{
	}

	function before_process () 
	{
		$content = '
		<form action="' . BASE . '/orders/place_order/" method="post">
		<button id="vam_checkout_button" type="submit">{lang}Confirm Order{/lang}</button>
		</form>';
		return $content;	
	}
	
}

?>