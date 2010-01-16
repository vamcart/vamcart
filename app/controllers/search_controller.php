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

class SearchController extends AppController {
	var $name = 'Search';
	
	function admin_global_search ()
	{
		$this->set('current_crumb',__('Search Results',true));
		
		$search_tables = $this->Search->find('all');
		$search_results = array();
		
		foreach($search_tables AS $key => $table)
		{
			$search_results[$key] = array();

			App::import('Model', $table['Search']['model']);
			$this->SearchModel =& new $table['Search']['model']();
			
			$search_conditions = $table['Search']['model'] . '.' . $table['Search']['field'] . ' LIKE \'%' . $this->data['Search']['term'] . '%\'';
			
			$search_results[$key] = $this->SearchModel->findAll($search_conditions,null,null,20);

//			$search_results[$key] = $this->SearchModel->find('all', array('conditions' => array($table['Search']['model'] . '.' . $table['Search']['field'].' LIKE' => $this->data['Search']['term'])));
		}
		
		$this->set('tables',$search_tables);
		$this->set('results',$search_results);
		
	}
}
?>