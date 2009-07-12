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

class LocaleComponent extends Object 
{

	function beforeFilter ()
	{
		
	}

    function startup(&$controller)
	{
		$this->controller =& $controller;
    }
	
	function custom_crumb ($format, $language_key, $count = 1)
	{
		$language_format = __('% ' . $format, true);
		if($language_format != '% ' . $format)
			$this->controller->set('current_crumb',sprintf($language_format, __n($language_key,$language_key, $count, true)));
	}

	function set_crumb($action=null,$controller=null)
	{
		if($action == null)
		{
			$action = $this->controller->action;
		}
		
		if($controller == null)
		{
			$controller = $this->controller->name;
		}
		
		// Only return a crumb if the language value is assigned something.
		$language_format = __('% ' . $action, true);
		if($language_format != '% ' . $action)
			return sprintf($language_format, __n($controller,$controller, 1, true));
			
	}
	
	
}
?>