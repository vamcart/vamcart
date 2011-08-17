<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class TemplatesController extends AppController {
	var $name = 'Templates';
	var $uses = array('Template','Content','UserPref');
	
	function admin_set_all_products ($template_id) 
	{
		$products = $this->Content->find('all');
		
		foreach($products AS $product)
		{
			$product['Content']['template_id'] = $template_id;
			$this->Content->save($product);
		}
	
		$this->Session->setFlash(__('You have updated multiple records.',true));				
		$this->redirect('/templates/admin/');
	}
	
	function admin_set_as_default ($template_id)
	{
		$this->setDefaultItem($template_id);
	}
	
	function expand_section($template_id) 
	{
		$user_prefs = $this->UserPref->find(array('name' => 'template_collpase', 'user_id' => $this->Session->read('User.id')));
		$template_collapse = explode(',', $user_prefs['UserPref']['value']);

		$new_collapsed = "";
		foreach($template_collapse AS $collapsed)
		{
			if($collapsed != $template_id)
				$new_collapsed .= $collapsed . ',';
		}
		
		$user_prefs['UserPref']['value'] = $new_collapsed;
	
		$this->UserPref->save($user_prefs);
		
		$this->redirect('/templates/admin/' . $this->RequestHandler->isAjax());		
	}


	function contract_section($template_id) 
	{
		$user_prefs = $this->UserPref->find(array('name' => 'template_collpase', 'user_id' => $this->Session->read('User.id')));
		$template_collapse = explode(',', $user_prefs['UserPref']['value']);

		$new_collapsed = "";
		foreach($template_collapse AS $collapsed)
		{
			$new_collapsed .= $collapsed . ',';
			if($collapsed == $template_id)
				$in_array = true;
		}
		
		if(!isset($in_array))
			$new_collapsed .= $template_id;
		
		$user_prefs['UserPref']['value'] = $new_collapsed;
	
		$this->UserPref->save($user_prefs);
		
		$this->redirect('/templates/admin/' . $this->RequestHandler->isAjax());		
	}
	
	function admin_delete_stylesheet_association($template_id, $stylesheet_id)
	{
		$this->Template->delete_single_association($template_id, $stylesheet_id);	
		$this->Session->setFlash(__('You have deleted a stylesheet association.', true));
		
		$this->redirect('/templates/admin_attach_stylesheets/' . $template_id);
	}
	
	function admin_attach_stylesheets ($template_id)
	{
		$this->set('current_crumb', __('Attach Stylesheets', true));
		$this->set('title_for_layout', __('Attach Stylesheets', true));
		// Get the template
		$this->Template->id = $template_id;
		$template = $this->Template->read();

		if(!empty($this->data))
		{
			// Construct an array of stylesheet IDs in the data so we can save teh HABTM
			foreach($template['Stylesheet'] AS $value)
			{
				$this->data['Stylesheet']['Stylesheet'][] = $value['id'];
			}
			$this->Template->save($this->data);
			
			// Get the template again
			$template = $this->Template->read();
		
		}


		$this->set('template', $template);
		
		// First get a list of all stylesheets
		$all_stylesheets = $this->Template->Stylesheet->find('list');
		
		
		// Loop through the template stylesheets, removing any that are already associatied
		// Figure out a cleaner way for this later
		foreach($template['Stylesheet'] AS $value)
		{
			$key = $value['id'];
			if(!empty($all_stylesheets[$key]))
			{
				unset($all_stylesheets[$key]);
			}
		}
		
		$this->set('available_stylesheets', $all_stylesheets);
		
	}

	function admin_copy ($template_id)
	{
		if(empty($this->data))
		{
			$this->set('current_crumb', __('Copy Template', true));
			$this->set('title_for_layout', __('Copy Template', true));
			$this->Template->id = $template_id;
			$this->set('template', $this->Template->read());
		}
		else
		{
			$this->Template->id = $template_id;
			$old_template = $this->Template->read();
			
			$new_template = $old_template;
			$new_template['Template']['id'] = null;
			$new_template['Template']['name'] = $this->data['Template']['name'];
			
			$this->Template->save($new_template);
			$new_template_id = $this->Template->getLastInsertId();
			
			$old_children = $this->Template->find('all', array('conditions' => array('parent_id' => $template_id)));
			foreach($old_children AS $old_child)
			{
				$this->Template->create();
				
				$new_child = $old_child;
				$new_child['Template']['id'] = null;
				$new_child['Template']['parent_id'] = $new_template_id;

				$this->Template->save($new_child);
			}
			
			$this->Session->setFlash(__('Record copied.', true));
			$this->redirect('/templates/admin/');
		}
		
	}
	
	function admin_delete ($template_id)
	{
		// First make sure nothing is using this template
		$check_content = $this->Content->find('count', array('conditions' => array('template_id' => $template_id)));
		
		// Don't allow the delete if something is utilizing this template
		if(($check_content) > 0)
		{
			$this->Session->setFlash(__('Could not delete template. Template is in use.', true));		
		}
		else
		{
			// Get all templates that have this template as a parent
			$child_templates = $this->Template->find('all', array('conditions' => array('parent_id' => $template_id)));
			foreach($child_templates AS $child)
			{
				$this->Template->delete($child['Template']['id']);
			}
			
			// Ok, delete the template
			$this->Template->delete($template_id);	
			$this->Session->setFlash(__('You deleted a template.', true));		
		}
		$this->redirect('/templates/admin/');
	}
	
	function admin_edit ($template_id)
	{
		$this->set('current_crumb', __('Template Content', true));
		$this->set('title_for_layout', __('Template Content', true));
		if(empty($this->data))	
		{
			$template = $this->Template->read(null, $template_id);
			
			if($template['Template']['parent_id'] == 0)
			{
				$layout_template = $this->Template->find(array('parent_id' => $template_id, 'template_type_id' => '1'));
				$this->redirect('/templates/admin_edit/' . $layout_template['Template']['id']);				
			}
			
			$this->data = $template;
			
			// Set the breadcrumb and breadcrumb info

			$this->Template->id = $template['Template']['parent_id'];
			$parent = $this->Template->read();
			
		}
		else
		{
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/templates/admin/');
				die();
			}
		
			$this->Template->save($this->data);		
			$this->Session->setFlash(__('Record saved.', true));
				
			if(isset($this->params['form']['apply']))
			{
				$this->redirect('/templates/admin_edit/' . $template_id);
			}
			else
			{
				$this->redirect('/templates/admin/');
			}				
		
		}
	}
	
	function admin_edit_details ($template_id)
	{
		$this->set('current_crumb', __('Edit Template', true));
		$this->set('title_for_layout', __('Edit Template', true));
		if(empty($this->data))
		{
			$this->Template->id = $template_id;
			$data = $this->Template->read();
			$this->set('data', $data);
		}
		else
		{
			$this->Template->save($this->data);
			$this->Session->setFlash(__('Record saved.', true));
			$this->redirect('/templates/admin/');
		}
	}
	
	function admin_new() 
	{
		$this->set('current_crumb', __('New Template', true));
		$this->set('title_for_layout', __('New Template', true));
		if(empty($this->data))
		{
		
		}
		else
		{
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/templates/admin/');
				die();
			}

			$this->Template->save($this->data);
			$template_id = $this->Template->getLastInsertId();
						
			$default_templates = $this->Template->TemplateType->find('all');
			foreach($default_templates AS $default)
			{
				$this->Template->create();
				$new_template = array();
				$new_template['Template']['parent_id'] = $template_id;
				$new_template['Template']['template_type_id'] = $default['TemplateType']['id'];				
				$new_template['Template']['name'] = $default['TemplateType']['name'];								
				$new_template['Template']['template'] = $default['TemplateType']['default_template'];				
				
				$this->Template->save($new_template);
			}
			

			$this->Session->setFlash(__('Record created.', true));
			$this->redirect('/templates/admin/');
		}
	}
	
	function admin($ajax = false)
	{
		$this->set('current_crumb', __('Templates Listing', true));
		$this->set('title_for_layout', __('Templates Listing', true));
		$this->set('templates',$this->Template->find('threaded', array('order' => array('Template.id ASC'))));
	
		$user_prefs = $this->UserPref->find(array('name' => 'template_collpase','user_id' => $this->Session->read('User.id')));	
		$exploded_prefs = explode(',', $user_prefs['UserPref']['value']);
	
		$this->set('user_prefs', $exploded_prefs);	
	}
	
}
?>