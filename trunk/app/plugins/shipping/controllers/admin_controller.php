<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * Partial: BakeSale (www.bakesalehq.com)
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

class AdminController extends ShippingAppController {
	var $uses = null;
	
	function edit($code)
	{
		App::import('Model', 'ShippingMethod');
		$this->ShippingMethod =& new ShippingMethod();
		
		$data = $this->ShippingMethod->findByCode($code);
	
		$keys = array();
		if(!empty($data['ShippingMethodValue']))
			$keys = array_combine(Set::extract($data, 'ShippingMethodValue.{n}.key'),
							  Set::extract($data, 'ShippingMethodValue.{n}.value'));		
				
		$this->set('data',$keys);
		$this->render($code);
	}
	
}
?>