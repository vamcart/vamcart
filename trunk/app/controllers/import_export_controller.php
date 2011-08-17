<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ImportExportController extends AppController {

	var $name = 'ImportExport';
	var $uses = null;

	function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Import/Export', true));
		$this->set('title_for_layout', __('Import/Export', true));
	}

	function import ($params)
	{

		// If they pressed cancel
		if(isset($this->params['form']['cancel']))
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