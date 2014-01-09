<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class LicenseController extends AppController {
	public $name = 'License';
	public $components = array('Check', 'Crypt');		

    public function admin_edit ($id = null)
	{
		$this->set('current_crumb', __('License Key', true));
		$this->set('title_for_layout', __('License Key', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/license/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->request->data = $this->License->read(null,$id);
		}
		else
		{
			$this->License->save($this->data);		
			$this->Session->setFlash(__('Record saved.', true));
			$this->redirect('/license/admin/');
		}		
	}

	public function admin_new ()
	{
		$this->redirect('/license/admin_edit/');
	}

	public function admin($ajax_request = false)
	{
  		$this->set('current_crumb', __('License Key', true));
		$this->set('title_for_layout', __('License Key', true));
		$data = $this->License->find('first');
		if($data) $data['License']['check'] = $this->Check->get($data['License']['licenseKey']);
		$data['License']['license'] = $this->Crypt->decrypt($data['License']['licenseKey'],'VamShop');
		$data['License']['params'] = explode(';',$data['License']['license']);
		$this->set('license_data',$data['License']);
	}
}
?>