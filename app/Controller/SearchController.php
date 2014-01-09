<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class SearchController extends AppController {
	public $name = 'Search';
	
	public function admin_global_search ()
	{
		$this->set('current_crumb',__('Search Results',true));
		$this->set('title_for_layout', __('Search Results', true));
		
		$search_tables = $this->Search->find('all');
		$search_results = array();
		
		foreach($search_tables AS $key => $table)
		{
			$search_results[$key] = array();

			App::import('Model', $table['Search']['model']);
			$SearchModel =& new $table['Search']['model']();
			
			$search_conditions = array($table['Search']['model'] . '.' . $table['Search']['field'].' LIKE' => '%'.$this->data['Search']['term'].'%');
			
			$search_results[$key] = $SearchModel->find('all', array('conditions' => $search_conditions));
		}
		
		$this->set('tables',$search_tables);
		$this->set('results',$search_results);
		
	}
}
?>