<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class ImportExportController extends AppController {

	public $name = 'ImportExport';
	public $uses = null;

	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Import/Export', true));
		$this->set('title_for_layout', __('Import/Export', true));
	}

	public function import ($params)
	{

		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/import_export/admin/');
			die();
		}
		
  $val = $this->data['ImportExport']['submittedfile'];
 if ( (!empty( $this->data['ImportExport']['submittedfile']['tmp_name']) && $this->data['ImportExport']['submittedfile']['tmp_name'] != 'none')) {
 $this->Session->setFlash( __('File Uploaded', true));		
 }
 $this->Session->setFlash( __('File Not Uploaded', true));		

	$xml = simplexml_load_file($this->data['ImportExport']['submittedfile']["tmp_name"]);

		$this->set('xml', $xml);
		
		//$this->redirect('/import_export/admin/');
	
	}
	
}

?>