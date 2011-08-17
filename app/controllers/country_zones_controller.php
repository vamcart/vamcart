<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class CountryZonesController extends AppController {
	var $name = 'CountryZones';
	var $uses = array('Country','CountryZone');
	

	function admin_delete ($country_id, $zone_id)
	{
		$this->CountryZone->delete($zone_id);
		$this->Session->setFlash(__('Record deleted.', true));
		$this->redirect('/country_zones/admin/' . $country_id);
	}
	
	function admin_edit ($country_id, $zone_id = null)
	{
		$this->set('current_crumb', __('Country Zone Details', true));
		$this->set('title_for_layout', __('Country Zone Details', true));
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
				$this->Session->setFlash(__('Record created.', true));
			else
				$this->Session->setFlash(__('Record saved.', true));			
			$this->redirect('/country_zones/admin/' . $country_id);
			die();
		}		
	}
	
	function admin_new ($country_id)
	{
		$this->redirect('/country_zones/admin_edit/' . $country_id);
	}
	
	function admin ($country_id)
	{
		$this->set('current_crumb', __('Country Zones Listing', true));
		$this->set('title_for_layout', __('Country Zones Listing', true));
		$this->Country->id = $country_id;
		$country = $this->Country->read();
		$this->set('current_crumb_info', $country['Country']['name']);
		
		$this->set('country', $country);
		$this->set('zones', $this->CountryZone->find('all', array('conditions' => array('country_id' => $country_id))));
	}
}
?>