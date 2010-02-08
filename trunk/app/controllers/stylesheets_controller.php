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

class StylesheetsController extends AppController {
	var $name = 'Stylesheets';
	
	function load($alias)
	{
		$alias = str_replace(".css","",$alias);
		$stylesheet = $this->Stylesheet->find("Stylesheet.id = '".$alias."' OR Stylesheet.alias = '".$alias."'");

		// Minify css
		$stylesheetcontent = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $stylesheet['Stylesheet']['stylesheet']);
		$stylesheetcontent = str_replace(array("\r\n", "\r", "\n", "\t", '/\s\s+/', '  ', '   '), '', $stylesheetcontent);
		$stylesheetcontent = str_replace(array(' {', '{ '), '{', $stylesheetcontent);
		$stylesheetcontent = str_replace(array(' }', '} '), '}', $stylesheetcontent);
		$output = $stylesheetcontent;

		App::import('Vendor', 'jsmin'.DS.'jsmin');
		$output = JSMin::minify($output);

		/* set MIME type */
		@ob_start ('ob_gzhandler');
		header("Content-Type: text/css");
		header("Cache-Control: must-revalidate");
		$offset = 72000 ;
		$ExpStr = "Expires: " .
		gmdate("D, d M Y H:i:s",
		time() + $offset) . " GMT";
		header($ExpStr); 

		echo '/* Begin Stylesheet: ' . $stylesheet['Stylesheet']['name'] . ' */';		
		echo $output;
		echo '/* End Stylesheet: ' . $stylesheet['Stylesheet']['name'] . ' */';				
		die();

	}


	function admin_delete_template_association($template_id, $stylesheet_id)
	{
		$this->Stylesheet->Template->delete_single_association($template_id, $stylesheet_id);	
		$this->Session->setFlash(__('You have deleted a template association.',true));
		
		$this->redirect('/stylesheets/admin_attach_templates/' . $stylesheet_id);
	}
	
	function admin_attach_templates ($stylesheet_id)
	{
		// Get the stylesheet
		$this->Stylesheet->id = $stylesheet_id;
		$stylesheet = $this->Stylesheet->read();
		if(!empty($this->data))
		{
			// Construct an array of stylesheet IDs in the data so we can save teh HABTM
			foreach($stylesheet['Template'] AS $value)
			{
				$this->data['Template']['Template'][] = $value['id'];
			}
			$this->Stylesheet->save($this->data);
			
			// Get the template again
			$stylesheet = $this->Stylesheet->read();
		
		}
		$this->set('current_crumb',__('Attach Template',true));
		$this->pageTitle = __('Attach Template', true);
		$this->set('stylesheet', $stylesheet);
		
		// First get a list of all stylesheets
		$all_templates = $this->Stylesheet->Template->find('list', array('parent_id' => '0'));
		
		
		// Loop through the template stylesheets, removing any that are already associatied
		// Figure out a cleaner way for this later
		foreach($stylesheet['Template'] AS $value)
		{
			$key = $value['id'];
			if(!empty($all_templates[$key]))
			{
				unset($all_templates[$key]);
			}
		}
		
		$this->set('available_templates', $all_templates);
		
	}
	
	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
	
	function admin_copy ($stylesheet_id)
	{
		$this->set('current_crumb',__('Copy Stylesheet',true));
		$this->pageTitle = __('Copy Stylesheet', true);
		if(empty($this->data))
		{
			$this->Stylesheet->id = $stylesheet_id;
			$this->set('stylesheet',$this->Stylesheet->read());
		}
		else
		{
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/stylesheets/admin/');
			}
			else
			{
			
				// If the alias is empty, generate it by the name, otherwise generate it with the alias again just for protection.
				$this->data['Stylesheet']['alias'] = $this->generateAlias($this->data['Stylesheet']['name']);	
				
				$this->Stylesheet->save($this->data);
				$stylesheet_id = $this->Stylesheet->getLastInsertId();
		
				$this->redirect('/stylesheets/admin_edit/' . $stylesheet_id . '/true');
			}
		}	
	}
	
	function admin_delete ($stylesheet_id)
	{
		// First make sure no templates are using this stylesheet
		$this->Stylesheet->id = $stylesheet_id;
		$stylesheet_find = $this->Stylesheet->read();
		
		// Don't allow the delete if a template is utilizing this stylesheet
		if(count($stylesheet_find['Template']) > 0)
		{
			$this->Session->setFlash(__('Could not delete stylesheet. Stylesheet is in use.',true));		
		}
		else
		{
			// Ok, delete the stylesheet
			$this->Stylesheet->del($stylesheet_id);	
			$this->Session->setFlash(__('You deleted a stylesheet.',true));		
		}
		$this->redirect('/stylesheets/admin/');
	}
	
	function admin_edit ($stylesheet_id = null)
	{
		$this->set('current_crumb', __('Stylesheet', true));
		$this->pageTitle = __('Stylesheet', true);
		if(($stylesheet_id == null) && (empty($this->data)))
		{	// We're creating a stylesheet
			$this->set('new_stylesheet', true);
			$this->set('data', null);
			$this->set('active_checked', 'checked'); // For the active checkbox
		}
		elseif(empty($this->data))	
		{	// Otherwise we're editing a stylesheet
			$this->Stylesheet->id = $stylesheet_id;
			$data = $this->Stylesheet->read();
			if($data['Stylesheet']['active'] = 1)
				$this->set('active_checked', 'checked');
			$this->set('data',$data);
		}
		else
		{	// We submitted data
			if(isset($this->params['form']['cancel']))
			{	
				$this->redirect('/stylesheets/admin/');
			}
			else
			{	
				// If the alias is empty, generate it by the name, otherwise generate it with the alias again just for protection.
				if($this->data['Stylesheet']['alias'] == "")
				{	
					$this->data['Stylesheet']['alias'] = $this->generateAlias( $this->data['Stylesheet']['name']);
				}
				else
				{
					$this->data['Stylesheet']['alias'] = $this->generateAlias($this->data['Stylesheet']['alias']);	
				}

			
				// Do the save
				$this->Stylesheet->save($this->data);			
				
				// Set the flash and stylesheet_id depending on if it's a new stylesheet
				if($this->data['Stylesheet']['id'] == "")	
				{
					$stylesheet_id = $this->Stylesheet->getLastInsertId();
					$this->Session->setFlash(__('You have created a new stylesheet.',true));
				}
				else
				{
					$this->Session->setFlash(__('You have updated a stylesheet.',true));
				}
			}
			
			if(isset($this->params['form']['apply']))
				$this->redirect('/stylesheets/admin_edit/' . $stylesheet_id);
			else
				$this->redirect('/stylesheets/admin/');
		}
	}
	
	function admin_new() 
	{
		$this->redirect('/stylesheets/admin_edit/');
	}
	
	function admin_modify_selected() 
	{
		foreach($this->params['data']['Stylesheet']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
			
				// Get the GCB from the database
				$this->Stylesheet->id = $value;
				$stylesheet = $this->Stylesheet->read();
			
				switch ($this->params['form']['multiaction']) 
				{
					case "delete":
					    $this->Stylesheet->del($value);
						$this->Session->setFlash(__('You have deleted multiple stylesheets.',true));		
					    break;
					case "activate":
					    $stylesheet['Stylesheet']['active'] = 1;
						$this->Stylesheet->save($stylesheet);
						$this->Session->setFlash(__('You have activated multiple stylesheets.',true));		
				    	break;
					case "deactivate":
					    $stylesheet['Stylesheet']['active'] = 0;
						$this->Stylesheet->save($stylesheet);
						$this->Session->setFlash(__('You have inactivated multiple stylesheets.',true));		
					    break;
				}
			}
		}
		$this->redirect('/stylesheets/admin/');
	}	
	
	function admin($ajax_request = false)
	{
		$this->set('current_crumb', __('Stylesheets Listing', true));
		$this->pageTitle = __('Stylesheets Listing', true);
		$this->set('stylesheets',$this->Stylesheet->find('all', array('order' => array('Stylesheet.name ASC'))));
		
	}
	
}
?>