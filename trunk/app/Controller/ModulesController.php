<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Folder', 'Utility');

class ModulesController extends AppController {
	public $name = 'Modules';
   
	public function admin ()
	{
		$this->set('current_crumb', __('Modules Listing', true));
		$this->set('title_for_layout', __('Modules Listing', true));
		$path = APP . 'Plugin' . DS;
		$module_path = new Folder($path);
		$dirs = $module_path->read();

		$modules = array();
		foreach($dirs[0] AS $dir)
		{
			if(substr($dir,0,6) == 'Module')
			{
				$module = array();
				$module['alias'] = strtolower(substr(preg_replace('/([A-Z])/', '_${1}', substr($dir,6,strlen($dir))) , 1));
				$module['name'] = Inflector::humanize($module['alias']);
				$module['installed'] = $this->Module->find('count', array('conditions' => array('alias' => $module['alias'])));
				
				$module['version'] = intval(file_get_contents(APP . 'Plugin' . DS . $dir . DS . 'version.txt'));
				
				if($module['installed'] > 0)
				{
					$db_module = $this->Module->find('first', array('conditions' => array('alias' => $module['alias'])));
					$module['installed_version'] = $db_module['Module']['version'];
				}
					
				$modules[] = $module;
			}
		}

		
		$this->set('modules',$modules);
				
	}

	public function admin_add ()
	{
		$this->set('current_crumb', __('Module Upload', true));
		$this->set('title_for_layout', __('Module Upload', true));
	}

	public function admin_upload ()
	{
		$this->set('current_crumb', __('Module Upload', true));
		$this->set('title_for_layout', __('Module Upload', true));

		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/modules/admin/');
			die();
		}
		
		$val = $this->data['AddModule']['submittedfile'];
		
		if ( (!empty( $this->data['AddModule']['submittedfile']['tmp_name']) && $this->data['AddModule']['submittedfile']['tmp_name'] != 'none')) {
			$this->Session->setFlash( __('Module Uploaded', true));		

			$this->destination = '../tmp/modules/';
			$this->filename = $this->data['AddModule']['submittedfile']['name'];
			$this->permissions = '0777';

				if (move_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'], $this->destination . $this->filename)) {
					chmod($this->destination . $this->filename, $this->permissions);
					App::import('Vendor', 'PclZip', array('file' => 'pclzip'.DS.'zip.php'));
					$this->archive = new PclZip('../tmp/modules/'.$this->filename);
						if ($this->archive->extract(PCLZIP_OPT_PATH,'../..') == 0)
							die(__('Error : Unable to unzip archive', true));
					@unlink($this->destination.$this->filename);
				} else {
							return false;
				}

		} else {
			$this->Session->setFlash( __('Module Not Uploaded', true));
		}		
		
		$this->redirect('/modules/admin/');
	
	}
	
}
?>