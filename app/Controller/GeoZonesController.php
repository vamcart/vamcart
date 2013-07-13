<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class GeoZonesController extends AppController {
	public $name = 'GeoZones';
	public $uses = array('Country', 'GeoZone','CountryZone');
	public $paginate = array('limit' => 20, 'order' => array('GeoZone.name' => 'asc'));

	public function admin_delete ($geo_zone_id)
	{
		$this->GeoZone->delete($geo_zone_id);
		$this->Session->setFlash(__('Record deleted.', true));
		$this->redirect('/geo_zones/admin/');
	}
	
	public function admin_country_zone_unlink($country_zone_id = null, $geo_zone_id = null)
	{
		$this->CountryZone->id = $country_zone_id;
		$country_zone = $this->CountryZone->read();
		$country_zone['CountryZone']['geo_zone_id'] = 0;
		$this->CountryZone->save($country_zone);

		$this->Session->setFlash(__('Country Zones unlinked.', true));
		$this->redirect('/geo_zones/admin_zones_edit/' . $geo_zone_id);
	}
	
	public function admin_country_zone_link()
	{
		$geo_zone_id = $this->data['geo_zone_id'];
		foreach ($this->data['country_zones_id'][0] as $country_id) {
			$this->CountryZone->id = $country_id;
			$country_zone = $this->CountryZone->read();
			$country_zone['CountryZone']['geo_zone_id'] = $geo_zone_id;
			$this->CountryZone->save($country_zone);
		}

		$this->Session->setFlash(__('Country Zones linked.', true));
		exit();
	}
	
	public function admin_edit ($geo_zone_id = null)
	{
		$this->set('current_crumb', __('Geo Zone Details', true));
		$this->set('title_for_layout', __('Geo Zone Details', true));

		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/geo_zones/admin/');
			die();
		}

		if(empty($this->data))
		{
			$this->data = $this->GeoZone->read(null, $geo_zone_id);
		}
		else
		{
			$this->GeoZone->save($this->data);
			
			if($this->data['GeoZone']['id'] == null) {
				$this->Session->setFlash(__('Record created.', true));
			} else {
				$this->Session->setFlash(__('Record saved.', true));
			}

			$this->redirect('/geo_zones/admin/');
			die();
		
		}
	}

	public function admin_zones_edit($geo_zone_id = null)
	{
		$data = $this->GeoZone->read(null, $geo_zone_id);
		$this->set('title_for_layout', __('Edit Zones for Geo Zone', true));
		$this->set('current_crumb', __('Edit Zones for Geo Zone', true) . ' - ' . $data['GeoZone']['name']);
		$this->set('geo_zone_id', $geo_zone_id);

		foreach ($data['CountryZone'] as $key => $country_zone) {
			$country = $this->GeoZone->CountryZone->find('first', array(
				'conditions' => array('CountryZone.country_id' => $country_zone['country_id'])
			));
			$data['CountryZone'][$key]['country_name'] = $country['Country']['name'];
		}

		$this->set(compact('data'));
	}
	
	public function admin_new ($geo_zone_id = null)
	{
		$this->redirect('/geo_zones/admin_edit/' . $geo_zone_id);
	}
	
	public function admin_modify_selected()
	{
		$build_flash = "";
		foreach ($this->params['data']['GeoZone']['modify'] AS $value) {
			// Make sure the id is valid
			if ($value > 0) {
				$this->GeoZone->id = $value;
				$geo_zone = $this->GeoZone->read();

				switch ($this->data['multiaction']) {
					case "delete":
						$this->GeoZone->delete($value);
						$build_flash .= __('Record deleted.', true) . ' ' . $geo_zone['GeoZone']['name'] . '<br />';
						break;
					default:
						break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/geo_zones/admin/');
	}

	public function admin_modify_country_zones_selected()
	{
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/geo_zones/admin/');
			die();
		}

		foreach ($this->params['data']['GeoZoneZones']['modify'] AS $value) {
			if ($value > 0) {
				$this->CountryZone->id = $value;
				$country_zone = $this->CountryZone->read();
				$country_zone['CountryZone']['geo_zone_id'] = 0;
				$this->CountryZone->save($country_zone);
				$build_flash = __('Country Zones unlinked.', true);
			}
		}

		$this->Session->setFlash($build_flash);
		$this->redirect('/geo_zones/admin_zones_edit/' . $this->params['data']['GeoZoneZones']['geo_zone_id']);
	}

	public function admin ($ajax_request = false)
	{
		$this->set('current_crumb', __('Geo Zones Listing', true));
		$this->set('title_for_layout', __('Geo Zones Listing', true));
		$data = $this->paginate('GeoZone');
		$this->set('data',$data);
	}
	
	public function admin_country_zones()
	{
		$countries = $this->Country->find('list', array(
					'fields' => array('Country.id', 'Country.name')
		));
		
		$this->set('countries', $countries);
	}
	
	public function admin_country_zones_getzones($country_id = null)
	{
		$this->layout = 'ajax';
		$zones = $this->CountryZone->find('list', array('conditions' => array('CountryZone.country_id' => $country_id), 'fields' => array('CountryZone.id', 'CountryZone.name')));
		$this->set('zones', $zones);
	}
}
?>