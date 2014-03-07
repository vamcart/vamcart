<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class GlobalContentBlocksController extends AppController {
	public $name = 'GlobalContentBlocks';

	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		
	public function admin_delete ($global_content_block_id)
	{
		$this->GlobalContentBlock->delete($global_content_block_id);	
		$this->Session->setFlash(__('Record deleted.', true));		
		$this->redirect('/global_content_blocks/admin/');
	}
	
	public function admin_edit ($global_content_block_id = null)
	{
		$this->set('current_crumb', __('Global Content Block Details', true));
		$this->set('title_for_layout', __('Global Content Block Details', true));
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/global_content_blocks/admin/');
			die();
		}
			
		if(empty($this->data))
		{	
			$this->request->data = $this->GlobalContentBlock->read(null, $global_content_block_id);
			
			if(empty($this->data))
			{
				$this->request->data['GlobalContentBlock']['id'] = null;
				$this->request->data['GlobalContentBlock']['active'] = 1;
			}
				
		}
		else
		{
			// Generate the alias based depending on whether or not we entered one.
			if($this->data['GlobalContentBlock']['alias'] == "")
				$this->request->data['GlobalContentBlock']['alias'] = $this->generateAlias($this->data['GlobalContentBlock']['name']);
			else
				$this->request->data['GlobalContentBlock']['alias'] = $this->generateAlias($this->data['GlobalContentBlock']['alias']);	
			
			// Save the GCB
			$this->GlobalContentBlock->save($this->data);		
			
			// Set the flash whether a new GCB or not
			if($global_content_block_id == null)
				$this->Session->setFlash(__('Record created.', true));		
			else
				$this->Session->setFlash(__('Record saved.', true));
		
			if(isset($this->data['apply']))
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
	
	public function admin_new ()
	{
		$this->redirect('/global_content_blocks/admin_edit/');
	}
	
	public function admin_modify_selected() 
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
			
				switch ($this->data['multiaction']) 
				{
					case "delete":
					    $this->GlobalContentBlock->delete($value);
						$build_flash .= __('Record deleted.', true) . ' ' . $gcb['GlobalContentBlock']['name'] . '<br />';		
					    break;
					case "activate":
					    $gcb['GlobalContentBlock']['active'] = 1;
						$this->GlobalContentBlock->save($gcb);
						$build_flash .= __('Record activated.', true) . ' ' . $gcb['GlobalContentBlock']['name'] . '<br />';		
				    	break;
					case "deactivate":
					    $gcb['GlobalContentBlock']['active'] = 0;
						$this->GlobalContentBlock->save($gcb);
						$build_flash .= __('Record deactivated.', true) . ' ' . $gcb['GlobalContentBlock']['name'] . '<br />';		
					    break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/global_content_blocks/admin/');
	}
	
	public function admin($ajax_request = false)
	{
		$this->set('current_crumb', __('Global Content Blocks Listing', true));
		$this->set('title_for_layout', __('Global Content Blocks Listing', true));
		$this->set('global_content_blocks', $this->GlobalContentBlock->find('all'));
	}
}
?>