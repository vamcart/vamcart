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

class StylesheetsController extends AppController {
	var $name = 'Stylesheets';
	
	function load($alias)
	{
		$alias = str_replace(".css","",$alias);
		$stylesheet = $this->Stylesheet->find("Stylesheet.id = '".$alias."' OR Stylesheet.alias = '".$alias."'");

		/* set MIME type */
		header("Content-Type: text/css");
		header("Cache-Control: must-revalidate");
		$offset = 72000 ;
		$ExpStr = "Expires: " .
		gmdate("D, d M Y H:i:s",
		time() + $offset) . " GMT";
		header($ExpStr); 

		echo '/* Selling Made Simple Stylesheet */';
		echo '/* Begin Stylesheet: ' . $stylesheet['Stylesheet']['name'] . ' */';		
		echo $stylesheet['Stylesheet']['stylesheet'];
		echo '/* End Stylesheet: ' . $stylesheet['Stylesheet']['name'] . ' */';				
		die();

	}


	function admin_delete_template_association($template_id, $stylesheet_id)
	{
		$this->Stylesheet->Template->delete_single_association($template_id, $stylesheet_id);	
		$this->Session->setFlash('You have deleted a template association.');
		
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
		$this->set('current_crumb','attach_templates');
		$this->set('stylesheet', $stylesheet);
		
		// First get a list of all stylesheets
		$all_templates = $this->Stylesheet->Template->generateList(array('parent_id' => '0'));
		
		
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
		
		
		$this->render('','admin');
	}
	
	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
	
	function admin_copy ($stylesheet_id)
	{
		$this->set('current_crumb','copy_stylesheet');
		if(empty($this->data))
		{
			$this->Stylesheet->id = $stylesheet_id;
			$this->set('stylesheet',$this->Stylesheet->read());
			$this->render('','admin');
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
			$this->Session->setFlash('Could not delete stylesheet.  stylesheet is in use.');		
		}
		else
		{
			// Ok, delete the stylesheet
			$this->Stylesheet->del($stylesheet_id);	
			$this->Session->setFlash('You deleted a stylesheet.');		
		}
		$this->redirect('/stylesheets/admin/');
	}
	
	function admin_edit ($stylesheet_id = null)
	{
		if(($stylesheet_id == null) && (empty($this->data)))
		{	// We're creating a stylesheet
			$this->set('new_stylesheet', true);
			$this->set('data', null);
			$this->set('active_checked', 'checked'); // For the active checkbox
			$this->render('','admin');
		}
		elseif(empty($this->data))	
		{	// Otherwise we're editing a stylesheet
			$this->Stylesheet->id = $stylesheet_id;
			$data = $this->Stylesheet->read();
			if($data['Stylesheet']['active'] = 1)
				$this->set('active_checked', 'checked');
			$this->set('data',$data);
			$this->render('','admin');
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
					$this->Session->setFlash('You have created a new stylesheet.');
				}
				else
				{
					$this->Session->setFlash('You have updated a stylesheet.');
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
						$this->Session->setFlash('You have deleted multiple stylesheets.');		
					    break;
					case "activate":
					    $stylesheet['Stylesheet']['active'] = 1;
						$this->Stylesheet->save($stylesheet);
						$this->Session->setFlash('You have activated multiple stylesheets.');		
				    	break;
					case "deactivate":
					    $stylesheet['Stylesheet']['active'] = 0;
						$this->Stylesheet->save($stylesheet);
						$this->Session->setFlash('You have inactivated multiple stylesheets.');		
					    break;
				}
			}
		}
		$this->redirect('/stylesheets/admin/');
	}	
	
	function admin($ajax_request = false)
	{
		$this->set('stylesheets',$this->Stylesheet->findAll(null,null,'Stylesheet.name ASC'));
		
		if($ajax_request == true)
			$this->render('','ajax');	
		else
			$this->render('','admin');
	}
	
}
?>