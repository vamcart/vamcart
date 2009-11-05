<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ContentsController extends AppController {
	var $components = array('ContentBase');
	var $helpers = array('TinyMce');
	var $name = 'Contents';

	/**
	* Uploads all images, and saves records to content_images
	*
	*/
	function upload_images ($content_id)
	{

		
		$directory = WWW_ROOT . IMAGES_URL . '/content/' . $content_id;
		if(!is_dir($directory))
			mkdir($directory);
			
			$fileObject = $_FILES['Filedata'];

			$filetype = $fileObject['type'];
			$filesize = $fileObject['size'];
			$filename = $fileObject['name'];
			$filetmpname = $fileObject['tmp_name'];

			move_uploaded_file($filetmpname, $directory.'/'.$filename);			
			
			// Create the database record
			$content_image = array();
			$content_image['ContentImage']['content_id'] = $content_id;
			$content_image['ContentImage']['image'] = $filename;
			// Calculate the image with the highest order
			$highest = $this->Content->ContentImage->find(array('content_id' => $content_id), null, 'ContentImage.order DESC');
			$content_image['ContentImage']['order'] = $highest['ContentImage']['order'] + 1;
			
			$this->Content->ContentImage->save($content_image);
					
	}

	/**
	* Moves a content item up or down under the same parent.
	*
	* The admin_move method is called from the app_controller.
	*
	* @param  int  $id The id of the content we're going to be moving.
	* @param  string  $direction String value of 'up' or 'down'
	*/
	function admin_move ($id, $direction)
	{
		$this->moveItem($id, $direction);		
	}


	/**
	* Sets a content item (Page, Product, or Category) to be the default item for the site.
	*
	* The setDefaultItem is called from the app_controller.
	*
	* @param  int  $content_id The id of the content we're going to be setting as active.
	*/
	function admin_set_as_default ($content_id)
	{
		$this->setDefaultItem($content_id);
	}

	/**
	* Toggles whether or not a content item gets shown in the menu
	*
	* @param  string  $content_id Id of the content item to change.
	*/	
	function admin_change_show_in_menu_status ($content_id) 
	{
		$this->Content->id = $content_id;
		$content = $this->Content->read();
		
		if($content['Content']['show_in_menu'] == 0)
		{
			$content['Content']['show_in_menu'] = 1;
		}
		else
		{
			$content['Content']['show_in_menu'] = 0;		
		}
		$this->Content->save($content);

		$this->redirect('/contents/admin/' . $this->RequestHandler->isAjax());		
	}
	
	/**
	* Toggles the active status of a content item.
	*
	* The changeActiveStatus is called from the app_controller.
	*
	* @param  int  $content_id The id of the content we're going to change.
	*/
	function admin_change_active_status ($content_id) 
	{
		$this->changeActiveStatus($content_id);	
	}

	/**
	* Deletes a content item.
	*
	* The content item will not be deleted if it's set as the default item.
	*
	* @param  int  $content_id The id of the content we're going to delete.
	*/	
	function admin_delete ($content_id)
	{	
		$this->Content->id = $content_id;
		$content = $this->Content->read();
		
		// Make sure we're not deleting the default content item
		if($content['Content']['default'] == 1)
		{
			$this->Session->setFlash(__('Error: Could not delete default record.', true));			
		}
		else
		{
			$this->Content->del($content_id, true);
			$this->Session->setFlash(__('You have deleted a record.', true));		
		}
		$this->redirect('/contents/admin/');
	}

	/**
	* Updates a div inside of contents/admin_edit with fields appropriate to the type of content.
	*
	* @param  int  $content_id The id of the current content item.
	*/	
	function admin_edit_type ($content_type_id, $content_id = null)
	{
		$this->Content->id = $content_id;
		$content = $this->Content->read();

		$this->Content->ContentType->id = $content_type_id;
		$content_type = $this->Content->ContentType->read();
		
		// If it's empty just render a product as default for now
		if(empty($content_type))
		{
			$model = 'ContentProduct';
			$view = 'ContentProduct';
		}
		else
		{	
			$model = $content_type['ContentType']['type'];
			$view = $content_type['ContentType']['type'];
		}


		$data = $this->Content->$model->find(array('content_id' => $content_id));
		$this->set('data', $data);
		$this->set('content_type_id', $content_type_id);
	}
	
	
	function generate_tax_list ()
	{
		return $this->Content->ContentProduct->Tax->find('list', array('order' => array('Tax.default DESC')));
	}

	/**
	* Calls the ContentBase component
	*/	
    function content_selflink_list ($avoid_id = null)
    {
		if($avoid_id != null)
			$conditions = "Content.id != '" . $avoid_id . "'";
		else
			$conditions = "";
			
       	return $this->ContentBase->generate_content_list($conditions);
    }

	function admin_core_pages_edit($content_id) 
	{
			$this->set('current_crumb', __('Edit',true));
			$this->Content->id = $content_id;			
			$data = $this->Content->read();
		
			// If we were able to read a value from the database
			if(!empty($data))
			{
				// Set the language values
				$tmp = $data['ContentDescription'];
			
				$data['ContentDescription'] = null;
				foreach($tmp AS $id => $value)
				{
					$key = $value['language_id'];
					$data['ContentDescription'][$key] = $value;
				}
			}

		
				if($data['Content']['active'] == 1)
					$this->set('active_checked','checked');
				else
					$this->set('active_checked',' ');

				if($data['Content']['show_in_menu'] == 1)
					$this->set('menu_checked','checked');
				else
					$this->set('menu_checked',' ');					
		
			$this->set('data',$data);
			$this->set('content_types',$this->Content->ContentType->find('list'));
			$this->set('parents', $this->ContentBase->generate_content_list());
			$this->set('templates', $this->Content->Template->find('list', array('parent_id' => '0')));
			$this->set('languages', $this->Content->ContentDescription->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
			
	}
	
	/**
	* Edits or creates a content item depending on whether or not $content_id was null
	*
	* @param  int $content_id ID of the content we are editing
	*/		
	function admin_edit ($content_id = null)
	{
		$this->set('current_crumb', __('Content Details', true));
		// IF we submitted the form
		if(!empty($this->data))
		{
			// Did the user pressed cancel?
			if(isset($this->params['form']['cancelbutton']))
			{
				if($content_id != null)
				{
					$content = $this->Content->read(null, $content_id);
					if($content['Content']['parent_id'] == '-1')
						$this->redirect('/contents/admin_core_pages/');
					else
						$this->redirect('/contents/admin/0/' . $content['Content']['parent_id']);die();
				}	
				else
				{
					$this->redirect('/contents/admin/'); die();
				}
				
			}
			
			// Generate the alias based depending on whether or not it's empty
			// If the alias is empty, generate it by the name, otherwise generate it with the alias again just for protection.
			if($this->data['Content']['alias'] == "")
			{	
				// If we're generating the alias by the name we first have to get the name from the default language
				// TODO: Change the way this gets the default language id for now its jsut set on english
				$default_language_id = $this->Session->read('Customer.language_id');
				$content_name = $this->data['ContentDescription'][$default_language_id]['name'][1];
				$this->data['Content']['alias'] = $this->generateAlias($content_name);
			}
			else
			{
				$this->data['Content']['alias'] = $this->generateAlias($this->data['Content']['alias']);	
			}
			
			// Get the content with the highest order set with the same parent_id and increase that by 1 if it's new
			if($this->data['Content']['order'] < 1)
			{
				$highest_order_content = $this->Content->find(array('Content.parent_id' => $this->data['Content']['parent_id']),null,'Content.order DESC');
				$new_order = $highest_order_content['Content']['order'] + 1;
				$this->data['Content']['order'] = $new_order;
								
			}
		
			// Figure out something to do here if we try to move to a child content item.
			
			
			
			
			
			// Save to the database
			$this->Content->save($this->data['Content']);	
			
			
			if($content_id == null)
			{
				// Get the content id if it's new
				$content_id = $this->Content->getLastInsertid();
			}

					
			
			// Lets just delete all of the description associations and remake them
			$descriptions = $this->Content->ContentDescription->find('all', array('conditions' => array('content_id' => $content_id)));
			foreach($descriptions AS $description)
			{
				$this->Content->ContentDescription->del($description['ContentDescription']['id']);
			}

			foreach($this->data['ContentDescription'] AS $id => $value)
			{
				$new_description = array();
				$new_description['ContentDescription']['content_id'] = $content_id;
				$new_description['ContentDescription']['language_id'] = $id;
				$new_description['ContentDescription']['name'] = $value['name'][$id];
				$new_description['ContentDescription']['description'] = $value['description'][$id];				
				$new_description['ContentDescription']['meta_title'] = $value['meta_title'][$id];				
				$new_description['ContentDescription']['meta_description'] = $value['meta_description'][$id];				
				$new_description['ContentDescription']['meta_keywords'] = $value['meta_keywords'][$id];				

				$this->Content->ContentDescription->create();
				$this->Content->ContentDescription->save($new_description);
			}
			
			// Now get all content types and loop through them.  Saving the necessary data.
			$content_types = $this->Content->ContentType->find('all');
			foreach($content_types AS $type)
			{
				$test_model = $type['ContentType']['type'];

				if(!empty($this->data[$test_model]))
					$model = $test_model;
			}
			
			$special_content = array();
			$special_content[$model] = $this->data[$model];
			$special_content[$model]['content_id'] = $content_id;

			// Check if we already have a record for this type of special content, if so delete it.
			// I'm sure there's a better way to do this
			$check_specified_type = $this->Content->$model->find(array('content_id' => $content_id));
			if(!empty($check_specified_type))
				$special_content[$model]['id']= $check_specified_type[$model]['id'];
			
			$this->Content->$model->save($special_content);
			
			
			$this->Session->setFlash(__('Record saved.', true));
		
			// Check if we pressed 'apply' otherwise just render
			if(isset($this->params['form']['applybutton']))
			{
				if($this->data['Content']['parent_id'] == '-1')
					$this->redirect('/contents/admin_core_pages_edit/' . $content_id);
				else
					$this->redirect('/contents/admin_edit/' . $content_id);
			}
			
				if($content_id != null)
				{
					$content = $this->Content->read(null, $content_id);
					if($content['Content']['parent_id'] == '-1')
						$this->redirect('/contents/admin_core_pages/');
					else
						$this->redirect('/contents/admin/0/' . $content['Content']['parent_id']);die();
				}	
				else
				{
					$this->redirect('/contents/admin/'); die();
				}
						
		}
		else	// The form has not been submitted
		{
			$this->Content->id = $content_id;			
			$data = $this->Content->read();
		
			// If we were able to read a value from the database
			if(!empty($data))
			{
				// Set the language values
				$tmp = $data['ContentDescription'];
			
				$data['ContentDescription'] = null;
				foreach($tmp AS $id => $value)
				{
					$key = $value['language_id'];
					$data['ContentDescription'][$key] = $value;
				}
			}

			// If it's a new content item
			if($content_id == null)
			{
				// If it's a new content item set some default checked values
				$this->set('active_checked','checked');
				$this->set('menu_checked','checked');	
			}
			else
			{
				if($data['Content']['active'] == 1)
					$this->set('active_checked','checked');
				else
					$this->set('active_checked',' ');

				if($data['Content']['show_in_menu'] == 1)
					$this->set('menu_checked','checked');
				else
					$this->set('menu_checked',' ');					
			}
		
			$this->set('data',$data);
			
			// Content type
			$content_types_translatable = $this->Content->ContentType->find('list');
			foreach($content_types_translatable AS $key => $value)
			{
			$content_types_translatable[$key] = __($value, true);
			}
			$this->set('content_types',$content_types_translatable);
			
			$this->set('parents', $this->ContentBase->generate_content_list());
			
			// Template
			$templates_translatable =  $this->Content->Template->find('list', array('parent_id' => '0'));
			foreach($templates_translatable AS $key => $value)
			{
			$templates_translatable[$key] = __($value, true);
			}
			$this->set('templates', $templates_translatable);
			$this->set('languages', $this->Content->ContentDescription->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
			
		}
	}

	/**
	* Redirects the user to the admin_edit method where all work is done.
	*/	
	function admin_new ()
	{
		$this->redirect('/contents/admin_edit/');
	}

	/**
	* Modifys all items selected by the user.
	*
	* Disallows the user from deleting the default content item.
	*/	
	function admin_modify_selected() 
	{
		$build_flash = "";
		foreach($this->params['data']['Content']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
			
				// Get the content item from the database
				$this->Content->id = $value;
				$content = $this->Content->read();
			
				switch ($this->params['form']['multiaction']) 
				{
					case "delete":
					
						// Check the count of the child elements, dont allow them to delete a content item with children yet
						$count_children = $this->Content->findCount(array('Content.parent_id' => $content['Content']['id']));
					if($count_children > 0)
					{
							$build_flash .= __('Unable to delete content item with children.', true);
					}
					else
					{
						    $this->Content->del($value, true);
							$build_flash .= __('Deleted a content item.', true);
					}
				    break;
					case "show_in_menu":
					    $content['Content']['show_in_menu'] = 1;
						$this->Content->save($content);
						$build_flash .= __('Now showing in menu.', true);
					break;
					case "hide_from_menu":
					    $content['Content']['show_in_menu'] = 0;
						$this->Content->save($content);
						$build_flash .= __('Now hiding from menu.', true);
					break;					
					case "activate":
					    $content['Content']['active'] = 1;
						$this->Content->save($content);
						$build_flash .= __('Activated content item.', true);
			    	break;
					case "deactivate":
					    $content['Content']['active'] = 0;
						$this->Content->save($content);
						$build_flash .= __('Inactivated content item.', true);						
				    break;
				}
			}
		}
		$this->Session->setFlash($build_flash);	
		$this->redirect('/contents/admin/');
	}	


	/**
	* Displays a list of all core content pages.
	*
	*/		
	function admin_core_pages ()
	{
		$this->set('current_crumb', __('Pages Listing',true));
		// Lets remove the hasMany association for now and associate it with our language of choice
		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
		$this->Content->bindModel(
	        array('hasOne' => array(
				'ContentDescription' => array(
                    'className' => 'ContentDescription',
					'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );
			
		$content_data = $this->Content->find('all', array('conditions' => array('Content.parent_id' => '-1'), 'order' => array('Content.order ASC')));
		// Loop through and assign the counts
		foreach($content_data AS $key => $value)
		{
			$content_data[$key]['Content']['count'] = $this->Content->findCount(array('Content.parent_id' => $value['Content']['id']));
		}
		
		$this->set('content_data', $content_data);
	}


	/**
	* Displays a list of all content items.
	*
	* @param  booleen  $ajax Uses the value in $ajax to determine whether or not to display the Ajax layout.
	*/		
	function admin ($ajax = false, $parent_id = 0)
	{
		$this->set('current_crumb', __('Listing', true));
		// Lets remove the hasMany association for now and associate it with our language of choice
		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
		$this->Content->bindModel(
	        array('hasOne' => array(
				'ContentDescription' => array(
                    'className' => 'ContentDescription',
					'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );
			
		$content_data = $this->Content->find('all', array('conditions' => array('Content.parent_id' => $parent_id), 'order' => array('Content.order ASC')));
		// Loop through and assign the counts
		foreach($content_data AS $key => $value)
		{
			$content_data[$key]['Content']['count'] = $this->Content->findCount(array('Content.parent_id' => $value['Content']['id']));
		}
		
		// Assign the parent content if $parent_id > 0
		if($parent_id > 0)
		{
			$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
			$this->Content->bindModel(array('hasOne' => array(
												'ContentDescription' => array(
								                    'className' => 'ContentDescription',
													'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')
								                )
								            )
								           	)
									    );
										
			$parent_content = $this->Content->read(null, $parent_id);
			$this->set('current_crumb_info', $parent_content['ContentDescription']['name']);
			$this->set('parent_content', $parent_content);			
		}
		
		$this->set('content_data', $content_data);
		$this->set('content_count', $this->Content->findCount(array('Content.parent_id' => $parent_id)));
	}

}
?>