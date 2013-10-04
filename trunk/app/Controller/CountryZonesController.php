<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class CountryZonesController extends AppController {
	public $name = 'CountryZones';
	public $uses = array('Country','CountryZone');

	public function admin_delete ($country_id, $zone_id)
	{
		$this->CountryZone->delete($zone_id);
		$this->Session->setFlash(__('Record deleted.', true));
		$this->redirect('/country_zones/admin/' . $country_id);
	}
	
	public function admin_edit ($country_id, $zone_id = null)
	{
		$this->set('current_crumb', __('Country Zone Details', true));
		$this->set('title_for_layout', __('Country Zone Details', true));
		$this->set('country_id', $country_id);

		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/country_zones/admin/' . $country_id);
			die();
		}
		
		if(empty($this->data))
		{
			$this->request->data = $this->CountryZone->read(null,$zone_id);
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
	
	public function admin_new ($country_id)
	{
		$this->redirect('/country_zones/admin_edit/' . $country_id);
	}
	
	public function admin ($country_id)
	{
		$this->set('current_crumb', __('Country Zones Listing', true));
		$this->set('title_for_layout', __('Country Zones Listing', true));
		$this->Country->id = $country_id;
		$country = $this->Country->read();
		$this->set('current_crumb_info', $country['Country']['name']);
		
		$this->set('country', $country);
		$this->set('zones', $this->CountryZone->find('all', array('conditions' => array('country_id' => $country_id))));
	}
	
	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['CountryZone']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->CountryZone->id = $value;
				$country_zone = $this->CountryZone->read();
				$country_zone_id = $country_zone['CountryZone']['country_id'];
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						$this->CountryZone->delete($value);
						$build_flash .= __('Record deleted.', true) . ' ' . $country_zone['CountryZone']['name'] . '<br />';									
					break;								
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/country_zones/admin/'.$country_zone_id);
	}	
		
}
?>