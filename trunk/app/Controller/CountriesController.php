<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class CountriesController extends AppController {
	public $name = 'Countries';
	public $uses = array('Country', 'CountryZone');
	public $components = array('RequestHandler');
	public $paginate = array('limit' => 20, 'order' => array('Country.name' => 'asc'));
	
	public function admin_edit ($country_id = null)
	{
		$this->set('current_crumb', __('Country Details', true));
		$this->set('title_for_layout', __('Edit', true));
		$this->set('active_checked', true);
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/countries/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->Country->id = $country_id;
			$data = $this->Country->read();
			if($data['Country']['active'] == 1) {
				$this->set('active_checked', true);
			} else {
				$this->set('active_checked', false);
			}

			$this->set('data', $data);
		}
		else
		{
			$this->Country->save($this->data);	
			if($country_id == null)	
				$this->Session->setFlash(__('Record created.', true));
			else
				$this->Session->setFlash(__('Record saved.', true));			
			$this->redirect('/countries/admin/');
			die();
		}		
	}

	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		
	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Country']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Country->id = $value;
				$country = $this->Country->read();
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						$this->Country->delete($value);
						$build_flash .= __('Record deleted.', true) . ' ' . $country['Country']['name'] . '<br />';									
					break;								
					case "activate":
					   $country['Country']['active'] = 1;
						$this->Country->save($country);
						$build_flash = __('You have activated multiple countries.',true);		
				    	break;
					case "deactivate":
					   $country['Country']['active'] = 0;
						$this->Country->save($country);
						$build_flash = __('You have inactivated multiple countries.',true);		
					    break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/countries/admin/');
	}	
	
	public function admin_delete ($country_id)
	{
		$this->Country->delete($country_id);
		$this->Session->setFlash( __('Record deleted.', true));
		$this->redirect('/countries/admin');
	}
	
	public function admin_new ()
	{
		$this->redirect('/countries/admin_edit/');
	}
	public function admin($ajax_request = false)
	{
		$this->set('current_crumb', __('Countries Listing', true));
		$this->set('title_for_layout', __('Countries Listing', true));
		$data = $this->paginate('Country');
		$this->set('data',$data);
		
	}
	
	public function billing_regions($id = null)
	{
		$this->layout = 'ajax';
		$zones = $this->CountryZone->find('list', array('conditions' => array('CountryZone.country_id' => (int)$id), 'fields' => array('CountryZone.id', 'CountryZone.name')));
		$this->set('zones', $zones);
	}

	public function shipping_regions($id = null)
	{
		$this->billing_regions($id);
	}

	public function address_book_regions($id = null)
	{
		$this->billing_regions($id);
	}
	
}
?>