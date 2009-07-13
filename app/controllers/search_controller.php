<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class SearchController extends AppController {
	var $name = 'Search';
	
	function admin_global_search ()
	{
		$this->set('current_crumb',__('Search Results',true));
		
		$search_tables = $this->Search->findAll();
		$search_results = array();
		
		foreach($search_tables AS $key => $table)
		{
			$search_results[$key] = array();

			loadModel($table['Search']['model']);
			$this->SearchModel =& new $table['Search']['model']();
			
			$search_conditions = $table['Search']['model'] . '.' . $table['Search']['field'] . ' LIKE \'%' . $this->data['Search']['term'] . '%\'';
			
			$search_results[$key] = $this->SearchModel->findAll($search_conditions,null,null,20);
		}
		
		$this->set('tables',$search_tables);
		$this->set('results',$search_results);
		
		$this->render('','admin');
	}
}
?>