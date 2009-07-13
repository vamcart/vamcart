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

class GlobalContentBlocksController extends AppController {
	var $name = 'GlobalContentBlocks';

	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		
	function admin_delete ($global_content_block_id)
	{
		$this->GlobalContentBlock->del($global_content_block_id);	
		$this->Session->setFlash(__('Record deleted.', true));		
		$this->redirect('/global_content_blocks/admin/');
	}
	
	function admin_edit ($global_content_block_id = null)
	{
		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/global_content_blocks/admin/');
			die();
		}
			
		if(empty($this->data))
		{	
			$this->data = $this->GlobalContentBlock->read(null, $global_content_block_id);
			
			if(empty($this->data))
			{
				$this->data['GlobalContentBlock']['id'] = null;
				$this->data['GlobalContentBlock']['active'] = 1;
			}
				
			$this->render('','admin');
		}
		else
		{
			// Generate the alias based depending on whether or not we entered one.
			if($this->data['GlobalContentBlock']['alias'] == "")
				$this->data['GlobalContentBlock']['alias'] = $this->generateAlias($this->data['GlobalContentBlock']['name']);
			else
				$this->data['GlobalContentBlock']['alias'] = $this->generateAlias($this->data['GlobalContentBlock']['alias']);	
			
			// Save the GCB
			$this->GlobalContentBlock->save($this->data);		
			
			// Set the flash whether a new GCB or not
			if($global_content_block_id == null)
				$this->Session->setFlash(__('Record created.', true));		
			else
				$this->Session->setFlash(__('Record saved.', true));
		
		
			if(isset($this->params['form']['apply']))
			{
				if($global_content_block_id == null)
					$global_content_block_id = $this->GlobalContentBlock->getLastInsertId();	
				$this->redirect('/global_content_blocks/admin_edit/' . $global_content_block_id);
			}
			else
			{
				$this->redirect('/global_content_blocks/admin/');
			}
		}
	}	
	
	function admin_new ()
	{
		$this->redirect('/global_content_blocks/admin_edit/');
	}
	
	function admin_modify_selected() 
	{
		$build_flash = "";
		foreach($this->params['data']['GlobalContentBlock']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
			
				// Get the GCB from the database
				$this->GlobalContentBlock->id = $value;
				$gcb = $this->GlobalContentBlock->read();
			
				switch ($this->params['form']['multiaction']) 
				{
					case "delete":
					    $this->GlobalContentBlock->del($value);
						$build_flash .= __('Record deleted.', true) . ': ' . $gcb['GlobalContentBlock']['name'] . '<br />';		
					    break;
					case "activate":
					    $gcb['GlobalContentBlock']['active'] = 1;
						$this->GlobalContentBlock->save($gcb);
						$build_flash .= __('Record activated.', true) . ': ' . $gcb['GlobalContentBlock']['name'] . '<br />';		
				    	break;
					case "deactivate":
					    $gcb['GlobalContentBlock']['active'] = 0;
						$this->GlobalContentBlock->save($gcb);
						$build_flash .= __('Record deactivated.', true) . ': ' . $gcb['GlobalContentBlock']['name'] . '<br />';		
					    break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/global_content_blocks/admin/');
	}
	
	function admin($ajax_request = false)
	{
		$this->set('global_content_blocks', $this->GlobalContentBlock->findAll());
		
		if($ajax_request == true)
			$this->render('','ajax');	
		else
			$this->render('','admin');
	}
}
?>