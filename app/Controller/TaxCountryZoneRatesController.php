<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class TaxCountryZoneRatesController extends AppController {
	public $name = 'TaxCountryZoneRates';
	
	public function list_zones_by_country($country_id) 
	{
		$zones = $this->TaxCountryZoneRate->CountryZone->find('list', array('country_id' => $country_id));
		$zones['ALL'] = __('All Country Zones',true);
		
		$this->set('zones', $zones);
	}	

	public function admin_delete ($tax_id, $zone_rate_id)
	{
		$this->TaxCountryZoneRate->delete($zone_rate_id);
		$this->Session->setFlash(__('Record deleted.',true));
		$this->redirect('/tax_country_zone_rates/admin/' . $tax_id);
	}	

	public function admin_edit ($tax_id,$rate_id)
	{
		$this->set('current_crumb', __('Tax Edit', true));
		$this->set('title_for_layout', __('Tax Edit', true));
		if(empty($this->data))
		{	
			$data = $this->TaxCountryZoneRate->find('first', array('conditions' => array('TaxCountryZoneRate.id' => $rate_id),null,null,2));
			$this->set('current_crumb_info',$data['CountryZone']['Country']['name'] . ' - ' . $data['CountryZone']['name']);			
			$this->set('data',$data);
		}
		else
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/tax_country_zone_rates/admin/' . $tax_id);
				die();
			}		
	
			$this->TaxCountryZoneRate->save($this->data);
			$this->Session->setFlash(__('Record saved.',true));
			$this->redirect('/tax_country_zone_rates/admin/' . $tax_id);
		}
	}

	public function admin_new ($tax_id)
	{
		$this->set('current_crumb', __('New Tax Zone', true));
		$this->set('title_for_layout', __('New Tax Zone', true));
		$tax = $this->TaxCountryZoneRate->Tax->read(null,$tax_id);
		if(empty($this->data))
		{
			$this->set('tax',$tax);
			
			$this->set('country_list',$this->TaxCountryZoneRate->CountryZone->Country->find('list'));
		}
		else
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/tax_country_zone_rates/admin/' . $tax_id);
				die();
			}
			
			if($this->data['TaxCountryZoneRate']['country_zone_id'] == 'ALL')
			{
				$country_zones = $this->TaxCountryZoneRate->CountryZone->find('all', array('conditions' => array('country_id' => $this->data['TaxCountryZoneRate']['country_id'])));
					
				foreach($country_zones AS $zone)
				{
					$new_zone = array();
					$new_zone['TaxCountryZoneRate']['tax_id'] = $tax_id;
					$new_zone['TaxCountryZoneRate']['country_zone_id'] = $zone['CountryZone']['id'];
					$new_zone['TaxCountryZoneRate']['rate'] = $this->data['TaxCountryZoneRate']['rate'];
					
					$this->TaxCountryZoneRate->create();
					$this->TaxCountryZoneRate->save($new_zone);
				}
			}
			else 
			{
				$this->TaxCountryZoneRate->save($this->data);
			}
			
			$this->Session->setFlash(__('Record saved.',true));
			$this->redirect('/tax_country_zone_rates/admin/' . $tax_id);
		}
	}

	public function admin_modify_selected($tax_id) 
	{
		foreach($this->params['data']['TaxCountryZoneRate']['modify'] AS $value)
		{
			if($value > 0)
			{
				$this->TaxCountryZoneRate->id = $value;
				$tax_rate = $this->TaxCountryZoneRate->read();
			
				switch ($this->data['multiaction']) 
				{
					case "delete":
					    $this->TaxCountryZoneRate->delete($value, true);
					    break;
				}
			}
		}
		$this->Session->setFlash( __('Record deleted.',true));	
		$this->redirect('/tax_country_zone_rates/admin/' . $tax_id);
	}	
	
	public function admin ($tax_id)
	{
		$this->set('current_crumb', __('Tax Zones', true));
		$this->set('title_for_layout', __('Tax Zones', true));
		if($tax_id == 0)
		{
			$this->Session->setFlash(__('Please select a tax class.',true));
			$this->redirect('/taxes/admin/');
			die();
		}
		$tax = $this->TaxCountryZoneRate->Tax->read(null,$tax_id);
		$this->set('current_crumb_info',$tax['Tax']['name']);
		$this->set('tax',$tax);
		$this->set('data',$this->TaxCountryZoneRate->find('all', array('conditions' => array('tax_id' => $tax_id))));

	}	
}
?>