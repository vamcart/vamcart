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


class AdminHelper extends Helper {
	var $helpers = array('Html', 'Javascript', 'Ajax');	

	########################################################
	# Functions for tabs
	########################################################	

	/**
	* Sets a content item (Page, Product, or Category) to be the default item for the site.
	*
	* Starts the content of a specific tab depending on $tab_alias.  $tab_alias should be the same as 
	* $tab_alias should be the same as one of the tabs already created.
	*
	* @param  string  $tab_alias Alias of the tab content.  Should be the same as the alias for the actual tab.
	* @return string	Beginning <div> tag of the Tab Contents
	*/
	function StartTabContent ($tab_alias)
	{
		return('<div id="' . $tab_alias . '">');		
	}
	
	
	/**
	* Closes the end of tab content.
	*
	* @return string	A closing </div> tag.
	*/	
	function EndTabContent ()
	{
		return('</div>');
	}
	
	/**
	* Begins the Tab display area.
	*
	* @return string	Returns the beginning of a formatted <div> element
	*/
	
	function StartTabs ()
	{
		return('<div id="tabs">');	
	}
	
	/**
	* Creates a tab with id = $tab_alias
	*
	* @param  string  $tab_alias Alias of the tab.
	* @return string	A <div> element to be used as a tab.
	*/	
	function CreateTab ($tab_alias, $tab_name = null)
	{
		return('<li><a href ="#' . $tab_alias . '">' . $tab_name . '</a></li>');
	}	

	/**
	* Closes the Tab display area and sets JavaScript to load a default tab on page load.
	*
	* @return string	Ending </div> element of tab area and JavaScript to load a tab.
	*/	
	function EndTabs ()
	{
		return('</div>');
	}
	
	function TableCells ($cell_array)
	{
		return($this->Html->TableCells(
				   $cell_array,
				   array("class" => "contentRowEven","onmouseout" =>"this.className='contentRowEven';", "onmouseover" => "this.className='contentRowEvenHover';"),
				   array("class" => "contentRowOdd","onmouseout" =>"this.className='contentRowOdd';", "onmouseover" => "this.className='contentRowOddHover';")
					)
				);
	}
	
	########################################################
	# Functions for bottom bar under tabular content
	########################################################	
	function CreateNewLink ($extra_path = null)
	{
		$title = sprintf(__('Create New', true), __(Inflector::underscore($this->params['controller']), true));
		//$title = __($this->params['controller'] . '_create_link', true);
		$path =  '/' . $this->params['controller'] . '/admin_new/' . $extra_path;

		if($this->params['plugin'] != "")
			$path = '/' . $this->params['plugin'] . $path;
			
		return($this->Html->link($title, $path, array('class' => 'button')));
	}
	
	function ActionBar($options = null, $new = true, $extra_path = null) 
	{
		$content = '
		<div class="addContent">
			' . (($new == true) ? $this->CreateNewLink($extra_path) : '') . '
		</div>
		<div class="multiAction">';
		
		if(!empty($options))
		{
			$content .=  __('With Selected: ', true) . '<select name="multiaction">';
			foreach($options AS $key => $value)
			{
				$content .= '<option value="' . $key . '">' . $value . '</option>';
			}
			
			$content .= '</select>
							<span class="button"><input onclick="return confirm(\'' . __('Are you sure? You may not be able to undo this action.', true) . '\');" type="submit" value="' . __('Submit', true) . '"/></span>
							<span>
								<a class="button" href="javascript:selectall();"><span>' . __('Select All', true) . '</span></a>
							</span>';

		}
		$content .= '</div><div class="clear"></div>';		
		return($content);
	}
	
	########################################################
	# Functions for tabular content
	########################################################	
	function MoveButtons ($data, $count) 
	{
		$button = "";

		if($data['order'] < $count)
		{
			$button .= $this->Ajax->link($this->Html->image('admin/icons/down.png'),'null', $options = array('url' => 'admin_move/' . $data['id'] . '/down', 'update' => 'content'),null,false);		
		}
		else
		{
			$button .= $this->Html->link($this->Html->image('admin/transparency.gif', array('width' => '16')), 'javascript:void(0);', null, null, false);
		}
		if($data['order'] > 1)
		{
			$button .= $this->Ajax->link($this->Html->image('admin/icons/up.png'),'null', $options = array('url' => 'admin_move/' . $data['id'] . '/up', 'update' => 'content'),null,false);		
		}
		return($button);
	}

	function DefaultButton ($data)
	{
		if($data['default'] == 1)
		{
			$button = $this->Html->image('admin/icons/true.png');
		}
		else
		{
			$button = $this->Ajax->link($this->Html->image('admin/icons/false.png'),'null', $options = array('url' => 'admin_set_as_default/' . $data['id'], 'update' => 'content'),null,false);		
		}
		return($button);
	}

	function ActionButton ($action, $path)
	{
		if($action == 'delete')
			$confirm_text = __('Confirm delete action?',true);
		else
			$confirm_text = null;
			
		$button = $this->Html->link($this->Html->image('admin/icons/' . $action . '.png'),$path,null,$confirm_text,false);
		return($button);		
	}
	
	function EmptyResults ($data)
	{
		if(empty($data))
			return '<div class="noData">' . __('No Data',true) . '</div>';
	}
	########################################################
	# Functions for menu & breadcrumbs
	########################################################		
	function MenuLink ($menuitem)
	{
		// Set a an empty value for attribues if it's not set.
		if(!isset($menuitem['attributes']))
			$menuitem['attributes'] = "";
			
		return($this->Html->link(__n($menuitem['text'],$menuitem['text'],2, true),$menuitem['path'],$menuitem['attributes'],null,false));
	}
	
	
	function DrawMenu ($navigation_walk)
	{
		$navigation = "";
		$navigation .= '<ul id="menu">';
		foreach($navigation_walk AS $nav)
		{
			$navigation .= '<li><span>' . $this->MenuLink($nav) . '</span>';
					
			if(!empty($nav['children']))	
			{
				$navigation .= '<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->';	
				$navigation .= '<dl>';	
				$navigation .= '<dt>' . $this->MenuLink($nav) . '</dt>';	
				foreach($nav['children'] AS $navchild)
				{
					$navigation .= '<dd>' . $this->MenuLink($navchild) . '</dd>';
				}
				$navigation .= '</dl>';
				$navigation .= '<!--[if lte IE 6]></td></tr></table></a><![endif]-->';
			}
			$navigation .= '</li>';
		}
		$navigation .= '</ul>';
		$navigation .= '<div class="clear"></div>' . "\n";
		
		return($navigation);
	}
	
	function GenerateBreadcrumbs ($navigation_walk, $current_crumb)
	{
		// Get the breadcrumb divider
		$divider = '<span class="separator"> >> </span>';
		
		$breadcrumbs = '';

		// Loop through to generage the child breadcrumb, then the top level
		foreach($navigation_walk AS $walk_key => $navigation)
		{
			$current_page = '/' . $this->params['controller'] . '/' . $this->params['action'] . '/';	
			
			// Check if the current page is in the children array
			if(!empty($navigation['children']))
			{
				foreach($navigation['children'] AS $child)
				{
					if(substr($current_page,0,strlen($child['path'])-1) == substr($child['path'],0,strlen($child['path'])-1))
					{
						// Top level link
						$breadcrumbs .= $this->MenuLink($navigation_walk[$walk_key]) . $divider;			
						// Child link
						$breadcrumbs .= $this->MenuLink($child) . $divider;			
					}
				}
			}
		}
		
		// Set the current breadcrumb
		$breadcrumbs .= __($current_crumb, true);
		
		return($breadcrumbs);
	
	}
	
	########################################################
	# Misc functions
	########################################################

	/**
	* Checks whether or not the flag image exists based off of the language, if not we just write the language name
	*
	* @param  array $flag An array of a language or country
	* @param  booleen $text_link If true will display a text link instead if image, if the image doesn't exist.
	* @return string	An <img> tag or name of the flag if $text_link is set to true.
	*/	
	function ShowFlag($flag, $text_link = true)
	{
		$image = $this->Html->image('flags/' . strtolower($flag['iso_code_2']) . '.png');	
		return($image);
	}
}
?>