<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
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
	
}

?>