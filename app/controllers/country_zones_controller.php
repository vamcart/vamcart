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

class CountryZonesController extends AppController {
	var $name = 'CountryZones';
	var $uses = array('Country','CountryZone');
	

	function admin_delete ($country_id, $zone_id)
	{
		$this->CountryZone->del($zone_id);
		$this->Session->setFlash(__('record_deleted', true));
		$this->redirect('/country_zones/admin/' . $country_id);
	}
	
	function admin_edit ($country_id, $zone_id = null)
	{
		$this->set('country_id', $country_id);

		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/country_zones/admin/' . $country_id);
			die();
		}
		
		if(empty($this->data))
		{
			$this->data = $this->CountryZone->read(null,$zone_id);
		}
		else
		{
			$this->CountryZone->save($this->data);	
			if($zone_id == null)	
				$this->Session->setFlash(__('record_created', true));
			else
				$this->Session->setFlash(__('record_saved', true));			
			$this->redirect('/country_zones/admin/' . $country_id);
			die();
		}		
		$this->render('','admin');			
	}
	
	function admin_new ($country_id)
	{
		$this->redirect('/country_zones/admin_edit/' . $country_id);
	}
	
	function admin ($country_id)
	{
		$this->Country->id = $country_id;
		$country = $this->Country->read();
		$this->set('current_crumb_info', $country['Country']['name']);
		
		$this->set('country', $country);
		$this->set('zones', $this->CountryZone->findAll(array('country_id' => $country_id)));
		$this->render('','admin');
	}
}
?>