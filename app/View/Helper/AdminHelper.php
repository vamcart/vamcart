<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('AppHelper', 'View');
class AdminHelper extends Helper {
	public $helpers = array('Html', 'Form', 'Js', 'Ajax');	

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
	public function StartTabContent ($tab_alias)
	{
		static $count = 0;
		$count++;
		
		return('<div id="' . $tab_alias . '" class="tab-pane fade'.(($count==1) ? ' in active' : '').'">');		
	}
	
	
	/**
	* Closes the end of tab content.
	*
	* @return string	A closing </div> tag.
	*/	
	public function EndTabContent ()
	{
		return('</div>');
	}
	
	/**
	* Begins the Tab display area.
	*
	* @return string	Returns the beginning of a formatted <div> element
	*/
	
	public function StartTabs ($id = null)
	{
		if (isset($id)) {
			$content = '<div id="'.$id.'" class="tab-content">';
		} else {
			$content = '<div id="myTabContent" class="tab-content">';
		}
		return $content;
	}
	
	/**
	* Creates a tab with id = $tab_alias
	*
	* @param  string  $tab_alias Alias of the tab.
	* @return string	A <div> element to be used as a tab.
	*/	
	public function CreateTab ($tab_alias, $tab_name = null, $icon = null, $class = null)
	{
		if (!empty($icon)) {
			$content = '<li'.(!is_null($class) ? ' class="'.$class.'"' : null).'><a href ="#' . $tab_alias . '" data-toggle="tab"><i class="'.$icon.'"></i> ' . $tab_name . '</a></li>';
		} else {
			$content = '<li'.(!is_null($class) ? ' class="'.$class.'"' : null).'><a href ="#' . $tab_alias . '" data-toggle="tab">' . $tab_name . '</a></li>';
		}
		return $content;
	}	

	/**
	* Closes the Tab display area and sets JavaScript to load a default tab on page load.
	*
	* @return string	Ending </div> element of tab area and JavaScript to load a tab.
	*/	
	public function EndTabs ()
	{
		
	$content = $this->Html->scriptBlock('
$(document).ready(function () {

$("#myTab a:first").tab("show"); // Select first tab	
$("#myTabLang a:first").tab("show"); // Select first tab	
$("#myTabNews a:first").tab("show"); // Select first tab	
$("#myTabSales a:first").tab("show"); // Select first tab	
	
});
', array('allowCache'=>false,'safe'=>false,'inline'=>true));			

	$content .= '</div>';
		
		return $content;
	}
	
	public function TableCells ($cell_array, $odd = false, $even = false)
	{
		return($this->Html->TableCells(
				   $cell_array,
				   array("class" => "contentRowEven".(!empty($odd) ? ' '.$odd : null)."","onmouseout" =>"this.className='contentRowEven".(!empty($odd) ? ' '.$odd : null)."';", "onmouseover" => "this.className='contentRowEvenHover".(!empty($odd) ? ' '.$odd : null)."';"),
				   array("class" => "contentRowOdd".(!empty($even) ? ' '.$even : null)."","onmouseout" =>"this.className='contentRowOdd".(!empty($even) ? ' '.$even : null)."';", "onmouseover" => "this.className='contentRowOddHover".(!empty($even) ? ' '.$even : null)."';")
					)
				);
	}
	
	########################################################
	# Functions for bottom bar under tabular content
	########################################################	
	public function CreateNewLink ($extra_path = null)
	{
		$title = sprintf(__('Create New', true), __(Inflector::underscore($this->params['controller']), true));
		//$title = __($this->params['controller'] . '_create_link', true);
		$path =  '/' . $this->params['controller'] . '/admin_new/' . $extra_path;

		if($this->params['plugin'] != "")
			$path = '/' . $this->params['plugin'] . $path;
			
		return($this->Html->link('<i class="cus-add"></i>'.' '.$title, $path, array('escape' => false, 'class' => 'btn btn-default')));
	}
	
	public function CreateExportLink ($extra_path = null)
	{
		$title = sprintf(__('Export', true), __(Inflector::underscore($this->params['controller']), true));
		$path =  '/' . $this->params['controller'] . '/download_export/' . $extra_path;

		if($this->params['plugin'] != "") {
			$path = '/' . $this->params['plugin'] . $path;
		}

		return($this->Html->link('<i class="cus-arrow-out"></i>'.' '.$title, $path, array('escape' => false, 'class' => 'btn btn-default')));
	}
	
	public function CreateImportLink ($extra_path = null)
	{
		$title = sprintf(__('Import', true), __(Inflector::underscore($this->params['controller']), true));
		$path =  '/' . $this->params['controller'] . '/admin_import/' . $extra_path;

		if($this->params['plugin'] != "") {
			$path = '/' . $this->params['plugin'] . $path;
		}

		return($this->Html->link('<i class="cus-arrow-in"></i>'.' '.$title, $path, array('escape' => false, 'class' => 'btn btn-default')));
	}
	
	public function ActionBar($options = null, $new = true, $extra_path = null, $export = false, $import = false) 
	{
		$content = '
		<div class="addContent">
			' . (($new == true) ? $this->CreateNewLink($extra_path) : '') . '
		</div>
		<div class="exportContent">
			' . (($export == true) ? $this->CreateExportLink($extra_path) : '') . '
		</div>
		<div class="importContent">
			' . (($import == true) ? $this->CreateImportLink($extra_path) : '') . '
		</div>

		<div class="multiAction">';
		
		if(!empty($options))
		{
				$content .= '<select name="multiaction" id="multiaction" onchange="if (this.form.onsubmit == undefined) { submitForm(this.form); } else { if (this.form.onsubmit() != false) { submitForm(this.form);} return false;} ">';
				$content .= '<option value="">'.__('With Selected:', true).'</option>';
			foreach($options AS $key => $value)
			{
				$content .= '<option value="' . $key . '">' . $value . '</option>';
			}
			
			$content .= '</select>
			<script>
function submitForm(form){
    if(confirm(\'' . __('Are you sure? You may not be able to undo this action.', true) . '\')){
        form.submit();
    } else {
        return false;
    }
}
			</script>
							<noscript><input class="btn btn-default" onclick="return confirm(\'' . __('Are you sure? You may not be able to undo this action.', true) . '\');" type="submit" value="' . __('Submit', true) . '"/></noscript>';

		}
		$content .= '</div><div class="clear"></div>';		
		return($content);
	}
	
	########################################################
	# Functions for tabular content
	########################################################	
	public function MoveButtons ($data, $count) 
	{
		$button = "";

		if($data['order'] < $count)
		{
			$button .= $this->Ajax->link($this->Html->image('admin/icons/down.png', array('alt' => __('Down', true),'title' => __('Down', true))),'null', $options = array('escape' => false, 'url' => 'admin_move/' . $data['id'] . '/down', 'update' => 'content'),null,false);		
		}
		else
		{
			$button .= $this->Html->link($this->Html->image('admin/transparency.png', array('width' => '16')), 'javascript:void(0);', array('escape' => false));
		}
		if($data['order'] > 1)
		{
			$button .= $this->Ajax->link($this->Html->image('admin/icons/up.png', array('alt' => __('Up', true),'title' => __('Up', true))),'null', $options = array('escape' => false, 'url' => 'admin_move/' . $data['id'] . '/up', 'update' => 'content'),null,false);		
		}
		return($button);
	}

	public function DefaultButton ($data)
	{
		if($data['default'] == 1)
		{
			$button = $this->Html->image('admin/icons/true.png', array('alt' => __('True', true),'title' => __('True', true)));
		}
		else
		{
			$button = $this->Ajax->link($this->Html->image('admin/icons/false.png', array('alt' => __('False', true),'title' => __('False', true))),'null', $options = array('escape' => false, 'url' => 'admin_set_as_default/' . $data['id'], 'update' => 'content'),null,false);		
		}
		return($button);
	}

	public function ActionButton ($action, $path, $alt)
	{
		if($action == 'delete')
			$confirm_text = __('Confirm delete action?',true);
		else
			$confirm_text = null;
			
		$button = $this->Html->link($this->Html->image('admin/icons/' . $action . '.png', array('alt' => $alt,'title' => $alt)), $path, array('escape' => false), $confirm_text);
		return($button);		
	}
	
	public function EmptyResults ($data)
	{
		if(empty($data))
			return '<div class="noData">' . __('No Data',true) . '</div>';
	}
	########################################################
	# Functions for menu & breadcrumbs
	########################################################		
	public function MenuLink ($menuitem, $parameters = null)
	{
		// Set a an empty value for attribues if it's not set.
		if(!isset($menuitem['attributes']))
			$menuitem['attributes'] = "";
			
		if(isset($menuitem['icon']) && $menuitem['icon'] != '') {
			$link =  $this->Html->link('<i class="'.$menuitem['icon'].'"></i> <span class="menu-text">' . __($menuitem['text'], true) . '</span><span class="selected"></span> ', $menuitem['path'], $parameters);
		} else {
			$link =  $this->Html->link('<i class="fa fa-file-o"></i> <span class="menu-text">' . __($menuitem['text'], true) . '</span><span class="selected"></span> ', $menuitem['path'], $parameters);
		}
			
		return($link);
	}
	
	public function MenuLinkDropdown ($menuitem, $parameters = null)
	{
		// Set a an empty value for attribues if it's not set.
		if(!isset($menuitem['attributes']))
			$menuitem['attributes'] = "";
			
		if(isset($menuitem['icon']) && $menuitem['icon'] != '') {
			$link =  $this->Html->link('<i class="'.$menuitem['icon'].'"></i> <span class="menu-text">' . __($menuitem['text'], true) . '</span><span class="selected"></span> ', '#', $parameters);
		} else {
			$link =  $this->Html->link('<i class="fa fa-file-o"></i> <span class="menu-text">' . __($menuitem['text'], true) . '</span><span class="selected"></span> ', '#', $parameters);
		}
			
		return($link);
	}
	
	public function DrawMenu ($navigation_walk)
	{
		$navigation = '';
		//$navigation .= '<ul class="nav panel-list">';

		$path = '/' . $this->params['controller'] . '/' . $this->params['action'] . '/';

		if($this->params['plugin'] != "")
			$path .= '/' . $this->params['plugin'] . '/' . $path;
			
		foreach($navigation_walk AS $nav)
		{
			if(!empty($nav['children'])) {	
			$navigation .= '
                    <li class="hoe-has-menu">
                        ' . $this->MenuLinkDropdown($nav, array('escape' => false)) . '
                    ';
			} else {
			$navigation .= ' 
                    <li'.(($path == $nav['path']) ? ' class="active"' : '').'>
                        ' . $this->MenuLink($nav, array('escape' => false)) . '
                    </li>
                    ';
			}
									
			if(!empty($nav['children']))	
			{
			$navigation .= '<ul class="hoe-sub-menu">';
				foreach($nav['children'] AS $navchild)
				{
					$navigation .= '<li'.(($path == $navchild['path']) ? ' class="active"' : '').'>' . $this->MenuLink($navchild, array('escape' => false)) . '</li>';
				}
			$navigation .= '</ul>';
			}
			if(!empty($nav['children'])) {	
			$navigation .= '</li>';
			}
		}
		//$navigation .= '</ul>';
		
		return($navigation);
	}
	
	public function GenerateBreadcrumbs ($navigation_walk, $current_crumb)
	{
		// Get the breadcrumb divider
		$divider = '';
		
		$breadcrumbs = '';
		//$breadcrumbs .= '<ul class="left-navbar breadcrumb">';

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
						$breadcrumbs .= '<li>'.$this->MenuLink($navigation_walk[$walk_key], array('escape' => false)) . $divider.'</li>';			
						// Child link
						$breadcrumbs .= '<li>'.$this->MenuLink($child, array('escape' => false)) . $divider.'</li>';			
					}
				}
			}
		}
		
		// Set the current breadcrumb
		//if ($this->params['action'] == "admin_top" or $this->params['action'] == "admin_index") $breadcrumbs .= '<li class="active">'.__($current_crumb, true).'</li>';
		if ($current_crumb) $breadcrumbs .= '<li class="active">'.CakeText::truncate(__($current_crumb, true),90,array('html' => true)).'</li>';

		//$breadcrumbs .= '</ul>';
		
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
	public function ShowFlag($flag, $text_link = true)
	{
		$image = $this->Html->image('flags/' . strtolower($flag['iso_code_2']) . '.png');	
		return($image);
	}

	/**
	* Checks whether or not the page icon exists
	*
	* @param  array $flag An array of a language or country
	* @param  booleen $text_link If true will display a text link instead if image, if the image doesn't exist.
	* @return string	An <img> tag or name of the flag if $text_link is set to true.
	*/	
	public function ShowPageHeaderStart($page_name = null, $icon = null)
	{
		$content = '';
		//if ($page_name) {
		$content .= '<div id="page">';
		//$content .= '<h2>';

		//if (!empty($icon)) {
			//$content .= '<i class="'.$icon.'"></i>'.' ' . $page_name;
		//} else {
			//$content .= $page_name;
		//}

		//$content .= '</h2>';
		$content .= '<div id="pageContent">';
		//}
		
		return $content;
	}

	/**
	* Checks whether or not the page icon exists
	*
	* @param  array $flag An array of a language or country
	* @param  booleen $text_link If true will display a text link instead if image, if the image doesn't exist.
	* @return string	An <img> tag or name of the flag if $text_link is set to true.
	*/	
	public function ShowPageHeaderEnd($page_name = null, $icon = null)
	{
			$content = '';
			$content .= '</div>';
			$content .= '</div>';
			
		return $content;
	}

	/**
	* Returns html form button
	*
	* @param  string  $name Alias of the tab.
	* @param  string  $icon Button icon.	* @param  array  $parameters Button type.	*
	* @return string	HTML Form Button.
	*/	
	public function formButton ($name, $icon = null, $parameters = null)
	{
		
		if (!empty($icon)) {
			$content = $this->Form->button('<i class="'.$icon.'"></i>'.' ' .__($name, true), $parameters);
		} else {
			$content = $this->Form->button(__($name, true), $parameters);
		}
		return $content;
	}	

	/**
	* Returns html form button at catalog
	*
	* @param  string  $name Alias of the tab.
	* @param  string  $icon Button icon.	* @param  array  $parameters Button type.	*
	* @return string	HTML Catalog Form Button.
	*/	
	public function formButtonCatalog ($name, $icon = null, $parameters = null)
	{
		
		if (!empty($icon)) {
			$content = $this->Form->button('<i class="'.$icon.'"></i>'.' ' .__($name, true), $parameters);
		} else {
			$content = $this->Form->button(__($name, true), $parameters);
		}
		return $content;
	}	

	/**
	* Returns html link button
	*
	* @param  string  $title HTML Link Title.
	* @param  string  $url URL.
	* @param  string  $icon Button icon.	* @param  array  $parameters Button type.	* @param  array  $confirmMessage Specify $confirmMessage to display a javascript confirm() dialog.	*
	* @return string	HTML Link Button.
	*/	
	public function linkButton ($title, $url, $icon = null, $parameters = null, $confirmMessage = false)
	{
		
		if (!empty($icon)) {
			$content = $this->Html->link('<i class="'.$icon.'"></i>'.' ' .__($title,true), $url, $parameters, $confirmMessage);
		} else {
			$content = $this->Html->link(__($title,true), $url, $parameters, $confirmMessage);
		}
		return $content;
	}	

	/**
	* Returns html link button for catalog
	*
	* @param  string  $title HTML Link Title.
	* @param  string  $url URL.
	* @param  string  $icon Button icon.	* @param  array  $parameters Button type.	* @param  array  $confirmMessage Specify $confirmMessage to display a javascript confirm() dialog.	*
	* @return string	HTML Link Button for Catalog.
	*/	
	public function linkButtonCatalog ($title, $url, $icon = null, $parameters = null, $confirmMessage = false)
	{
		
		if (!empty($icon)) {
			$content = $this->Html->link('<i class="'.$icon.'"></i>'.' ' .__($title,true), $url, $parameters, $confirmMessage);
		} else {
			$content = $this->Html->link(__($title,true), $url, $parameters, $confirmMessage);
		}
		return $content;
	}	
	
}

?>