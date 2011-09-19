<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class LicenseController extends AppController {
	var $name = 'License';
	var $data;

    function admin_edit ($id = null)
	{
		$this->set('current_crumb', __('License Key', true));
		$this->set('title_for_layout', __('License Key', true));
		if(empty($this->data))
		{
			$this->data = $this->License->read(null,$id);
		}
		else
		{
			// If they pressed cancel
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/license/admin/');
				die();
			}

			$this->License->save($this->data);
			$this->Session->setFlash(__('Record saved.',true));
			$this->redirect('/license/admin/');
		}
	}

	function admin_new ()
	{
		$this->redirect('/license/admin_edit/');
	}

	function admin($ajax_request = false)
	{
  		$this->set('current_crumb', __('License Key', true));
		$this->set('title_for_layout', __('License Key', true));
		$this->data = $this->License->find('first');
		if($this->data) $this->data['License']['check'] = $this->Check->get($this->data['License']['licenseKey']);
		$this->data['License']['license'] = $this->Crypt->decrypt($this->data['License']['licenseKey'],'VamCart');
		$this->data['License']['params'] = explode(';',$this->data['License']['license']);
		$this->set('license_data',$this->data['License']);
	}
}
?>