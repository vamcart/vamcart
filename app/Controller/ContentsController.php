<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class ContentsController extends AppController {
	public $helpers = array('TinyMce');
	public $name = 'Contents';

	/**
	* Uploads all images, and saves records to content_images
	*
	*/
	public function upload_images ($content_id)
	{

		
		$directory = WWW_ROOT . IMAGES_URL . '/content/' . $content_id;
		if(!is_dir($directory)) {
			mkdir($directory);
		}
		
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
		$highest = $this->Content->ContentImage->find('first', array('conditions' => array('content_id' => $content_id), null, 'ContentImage.order DESC'));
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
	public function admin_move ($id, $direction)
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
	public function admin_set_as_default ($content_id)
	{
		$this->setDefaultItem($content_id);
	}

	/**
	* Toggles whether or not a content item gets shown in the menu
	*
	* @param  string  $content_id Id of the content item to change.
	*/	
	public function admin_change_show_in_menu_status ($content_id) 
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

		$this->redirect('/contents/admin/0/' . $content['Content']['parent_id'] . '/' . $this->RequestHandler->isAjax());
	}

	public function admin_change_yml_export_status ($content_id) 
	{
		$this->Content->id = $content_id;
		$content = $this->Content->read();

		if ($content['Content']['yml_export'] == 0) {
			$content['Content']['yml_export'] = 1;
		} else {
			$content['Content']['yml_export'] = 0;
		}

		$this->Content->save($content);

		$this->redirect('/contents/admin/0/' . $content['Content']['parent_id'] . '/' . $this->RequestHandler->isAjax());
	}


	/**
	* Toggles the active status of a content item.
	*
	* The changeActiveStatus is called from the app_controller.
	*
	* @param  int  $content_id The id of the content we're going to change.
	*/
	public function admin_change_active_status ($content_id) 
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
	public function admin_delete ($content_id)
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
			$this->Content->delete($content_id, true);
			$this->Session->setFlash(__('You have deleted a record.', true));		
		}
		$this->redirect('/contents/admin/0/' . $content['Content']['parent_id']);
	}

	/**
	* Updates a div inside of contents/admin_edit with fields appropriate to the type of content.
	*
	* @param  int  $content_id The id of the current content item.
	*/	
	public function admin_edit_type ($content_type_id, $content_id = null)
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

		$data = $this->Content->$model->find('first', array('conditions' => array('content_id' => $content_id)));
		$this->set('data', $data);
		$this->set('content_type_id', $content_type_id);
	}
	
	
	public function generate_tax_list ()
	{
		$tax_list_translatable = $this->Content->ContentProduct->Tax->find('list', array('order' => array('Tax.default DESC')));
		foreach($tax_list_translatable AS $key => $value)
		{
		$tax_list_translatable[$key] = __($value, true);
		}
		
		return $tax_list_translatable;
	}
	
	public function generate_order_statuses_list()
	{
		App::import('Model', 'OrderStatus');
		$OrderStatus = new OrderStatus();

		$OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$OrderStatus->bindModel(
			array('hasOne' => array(
				'OrderStatusDescription' => array(
					'className' => 'OrderStatusDescription',
					'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
				)
			))
		);

		$order_statuses_list = $OrderStatus->find('all', array('order' => array('OrderStatus.order')));

		$order_statuses_list_ = array();
		foreach ($order_statuses_list as $status) {
			$order_statuses_list_[$status['OrderStatus']['id']] = $status['OrderStatusDescription']['name'];
		}
		
		return $order_statuses_list_;
	}

	public function admin_core_pages_edit($content_id) 
	{
			$this->set('current_crumb', __('Edit',true));
			$this->set('title_for_layout', __('Edit', true));
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
					$this->set('active_checked',true);
				else
					$this->set('active_checked',false);

				if($data['Content']['show_in_menu'] == 1)
					$this->set('menu_checked',true);
				else
					$this->set('menu_checked',false);					
		
			$this->set('data',$data);
			$this->set('content_types',$this->Content->ContentType->find('list'));
			// Template
			$templates_translatable =  $this->Content->Template->find('list', array('conditions'=>array('parent_id' => '0')));
			foreach($templates_translatable AS $key => $value)
			{
			$templates_translatable[$key] = __($value, true);
			}
			$this->set('templates', $templates_translatable);
			$this->set('languages', $this->Content->ContentDescription->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
			
	}
	
	/**
	* Edits or creates a content item depending on whether or not $content_id was null
	*
	* @param  int $content_id ID of the content we are editing
	*/		
	public function admin_edit ($content_id = 0, $parent_id = 0)
	{
		$this->set('current_crumb', __('Edit', true));
		$this->set('title_for_layout', __('Content', true));
		// IF we submitted the form
		if(!empty($this->data))
		{
			// Did the user pressed cancel?
			if(isset($this->data['cancelbutton']))
			{
				if($content_id != 0)
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
			
			if (7 == $this->data['Content']['content_type_id']) {

				if (isset($this->data['ContentDownloadable']['delete']) && $this->data['ContentDownloadable']['delete'] ) {
					$content_downloadable = $this->Content->ContentDownloadable->find('all', array('conditions' => array('content_id' => $content_id)));
					foreach ($content_downloadable as $download) {
						if ('' != $download['ContentDownloadable']['filestorename']) {
							@unlink('./downloads/' . $download['ContentDownloadable']['filestorename']);
						}
					}
					$this->request->data['ContentDownloadable']['filename'] = '';
					$this->request->data['ContentDownloadable']['filestorename'] = '';
				} else {
					if (isset($this->data['ContentDownloadable']['file'])
					    && $this->data['ContentDownloadable']['file']['error'] == 0
					    && is_uploaded_file($this->data['ContentDownloadable']['file']['tmp_name'])) {

						$store_name = $this->_random_string();

						$content_downloadable = $this->Content->ContentDownloadable->find('all', array('conditions' => array('content_id' => $content_id)));
						foreach ($content_downloadable as $download) {
							if ('' != $download['ContentDownloadable']['filestorename']) {
								@unlink('./downloads/' . $download['ContentDownloadable']['filestorename']);
							}
						}

						move_uploaded_file($this->data['ContentDownloadable']['file']['tmp_name'], './downloads/' . $store_name);
						$this->request->data['ContentDownloadable']['filename'] = $this->data['ContentDownloadable']['file']['name'];
						$this->request->data['ContentDownloadable']['filestorename'] = $store_name;

					}
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
				$this->request->data['Content']['alias'] = $this->generateAlias($content_name);
			}
			else
			{
				$this->request->data['Content']['alias'] = $this->generateAlias($this->data['Content']['alias']);
			}
			
			// Get the content with the highest order set with the same parent_id and increase that by 1 if it's new
			if($this->data['Content']['order'] < 1)
			{
				$highest_order_content = $this->Content->find('first', array('conditions' => array('Content.parent_id' => $this->data['Content']['parent_id']),null,'Content.order DESC'));
				$new_order = $highest_order_content['Content']['order'] + 1;
				$this->request->data['Content']['order'] = $new_order;
								
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
				$this->Content->ContentDescription->delete($description['ContentDescription']['id']);
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
			$check_specified_type = $this->Content->$model->find('first', array('conditions' => array('content_id' => $content_id)));
			if(!empty($check_specified_type))
				$special_content[$model]['id']= $check_specified_type[$model]['id'];
			
			$this->Content->$model->save($special_content);
			
			
			$this->Session->setFlash(__('Record saved.', true));
		
			// Check if we pressed 'apply' otherwise just render
			if(isset($this->data['applybutton']))
			{
				if($this->data['Content']['parent_id'] == '-1')
					$this->redirect('/contents/admin_core_pages_edit/' . $content_id);
				else
					$content = $this->Content->read(null, $content_id);
					$this->redirect('/contents/admin_edit/' . $content_id . '/' . $content['Content']['parent_id']);
			}
			
			if($content_id != 0)
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
			if($content_id == 0)
			{
				// If it's a new content item set some default checked values
				$this->set('active_checked',true);
				$this->set('menu_checked',true);	
			}
			else
			{
				if(isset($data['Content']['active']) && $data['Content']['active'] == 1)
					$this->set('active_checked',true);
				else
					$this->set('active_checked',false);

				if(isset($data['Content']['show_in_menu']) && $data['Content']['show_in_menu'] == 1)
					$this->set('menu_checked',true);
				else
					$this->set('menu_checked',false);					
			}
		
			$this->set('content_id',$content_id);
			$this->set('data',$data);
			
			// Content type
			$content_types_translatable = $this->Content->ContentType->find('list');
			foreach($content_types_translatable AS $key => $value)
			{
				$content_types_translatable[$key] = __($value, true);
			}
			$this->set('content_types',$content_types_translatable);
			
			$this->set('parent_id', $parent_id);
			
			// Template
			$templates_translatable =  $this->Content->Template->find('list', array('conditions'=>array('parent_id' => '0')));
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
	public function admin_new ($content_id = 0, $parent_id = 0)
	{
		$this->redirect('/contents/admin_edit/'.$content_id.'/'.$parent_id);
	}

	/**
	* Modifys all items selected by the user.
	*
	* Disallows the user from deleting the default content item.
	*/	
	public function admin_modify_selected() 
	{
		$build_flash = "";
		$target_page = '/contents/admin/';
		foreach($this->params['data']['Content']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
			
				// Get the content item from the database
				$this->Content->id = $value;
				$content = $this->Content->read();
			
				switch ($this->data['multiaction']) 
				{
					case "delete":
						$target_page = '/contents/admin/0/' . $content['Content']['parent_id'];
						// Check the count of the child elements, dont allow them to delete a content item with children yet
						$count_children = $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'])));
						if($count_children > 0)
						{
							$build_flash .= __('Unable to delete content item with children.', true);
						}
						else
						{
							$this->Content->delete($value, true);
							$build_flash .= __('Deleted a content item.', true);
						}
						break;
					case "show_in_menu":
						$content['Content']['show_in_menu'] = 1;
						$this->Content->save($content);
						$build_flash .= __('Now showing in menu.', true);
						$target_page = '/contents/admin/0/' . $content['Content']['parent_id'];
						break;
					case "hide_from_menu":
						$content['Content']['show_in_menu'] = 0;
						$this->Content->save($content);
						$build_flash .= __('Now hiding from menu.', true);
						$target_page = '/contents/admin/0/' . $content['Content']['parent_id'];
						break;
					case "yml_export":
						$content['Content']['yml_export'] = 1;
						$this->Content->save($content);
						$build_flash .= __('Now exporting to YML.', true);
						$target_page = '/contents/admin/0/' . $content['Content']['parent_id'];
						break;
					case "yml_not_export":
						$content['Content']['yml_export'] = 0;
						$this->Content->save($content);
						$build_flash .= __('Now not exporting to YML.', true);
						$target_page = '/contents/admin/0/' . $content['Content']['parent_id'];
						break;
					case "activate":
						$content['Content']['active'] = 1;
						$this->Content->save($content);
						$build_flash .= __('Activated content item.', true);
						$target_page = '/contents/admin/0/' . $content['Content']['parent_id'];
						break;
					case "deactivate":
						$content['Content']['active'] = 0;
						$this->Content->save($content);
						$build_flash .= __('Inactivated content item.', true);
						$target_page = '/contents/admin/0/' . $content['Content']['parent_id'];
						break;
					case "copy":
						$parent_id = $this->data['target_category'];
						$this->_copy_content($content, $parent_id);
						$build_flash .= __('Copied content item.', true);
						$target_page = '/contents/admin/0/' . $parent_id;
						break;
					case "move":
						$parent_id = $this->data['target_category'];
						$content['Content']['parent_id'] = $parent_id;
						$this->Content->save($content);
						$build_flash .= __('Moved content item.', true);
						$target_page = '/contents/admin/0/' . $parent_id;
						break;
					default:
						break;
				}
			}
		}
		$this->Session->setFlash($build_flash);	
		$this->redirect($target_page);
	}	


	/**
	* Displays a list of all core content pages.
	*
	*/		
	public function admin_core_pages ()
	{
		$this->set('current_crumb', __('Pages Listing',true));
		$this->set('title_for_layout', __('Pages Listing', true));
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
			$content_data[$key]['Content']['count'] = $this->Content->find('count', array('conditions' => array('Content.parent_id' => $value['Content']['id'])));
		}
		
		$this->set('content_data', $content_data);
	}


	/**
	* Displays a list of all content items.
	*
	* @param  booleen  $ajax Uses the value in $ajax to determine whether or not to display the Ajax layout.
	*/		
	public function admin ($ajax = false, $parent_id = 0)
	{
		$this->set('current_crumb', __('Listing', true));
		$this->set('title_for_layout', __('Content', true));
		// Lets remove the hasMany association for now and associate it with our language of choice
		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
		$this->Content->bindModel(
			array('hasOne' => array(
						'ContentDescription' => array(
							'className' => 'ContentDescription',
							'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
							)
						)
			)
		);

		$content_data = $this->Content->find('all', array('conditions' => array('Content.parent_id' => $parent_id), 'order' => array('Content.order ASC')));
		// Loop through and assign the counts
		foreach($content_data AS $key => $value)
		{
			$content_data[$key]['Content']['count'] = $this->Content->find('count', array('conditions' => array('Content.parent_id' => $value['Content']['id'])));
		}
		
		// Assign the parent content if $parent_id > 0
		if($parent_id > 0)
		{
			$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
			$this->Content->bindModel(array('hasOne' => array(
									'ContentDescription' => array(
										'className' => 'ContentDescription',
										'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
										)
									)
							)
			);

			$parent_content = $this->Content->read(null, $parent_id);
			$this->set('current_crumb_info', $parent_content['ContentDescription']['name']);
			$this->set('parent_content', $parent_content);			
		}
		
		$this->set('content_data', $content_data);
		$this->set('content_count', $this->Content->find('count', array('conditions' => array('Content.parent_id' => $parent_id))));
		$last_content_id = $this->Content->find('first', array('order' => array('Content.id DESC')));
		$last_content_id = $last_content_id['Content']['id']+1;
		$this->set('last_content_id', $last_content_id);
	}
	
	public function admin_categories_tree()
	{
		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));

		$this->Content->bindModel(array('hasOne' => array(
								'ContentDescription' => array(
									'className' => 'ContentDescription',
									'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
									)
								)
						)
		);
		
		$categories = $this->Content->find('threaded', array('conditions' => array('Content.content_type_id' => 1)));
		$tree = array();
		foreach ($categories as $category) {
			$this->_add_tree_node($tree, $category, 0);
		}
		$this->set('content_data', $tree);
	}


	public function admin_products_tree($parent_node_id, $products_id)
	{
		$product = $this->Content->find('first', array('conditions' => array('Content.id' => (int)$products_id)));
		$related = array();

		foreach ($product['xsell'] as $relation) {
			$related[] = $relation['id'];
		}

		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));

		$this->Content->bindModel(array('hasOne' => array(
								'ContentDescription' => array(
									'className' => 'ContentDescription',
									'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
									)
								)
						)
		);

		$categories = $this->Content->find('all', array('conditions' => array('Content.content_type_id' => array(1, 2, 7), 'Content.parent_id' => (int)$parent_node_id, 'Content.show_in_menu' => 1)));

		$nodes = array();

		foreach ($categories as $category) {
			$node = new stdClass;
			$node->title = $category['ContentDescription']['name'];

			if (1 == $category['Content']['content_type_id']) {
				$node->isFolder = true;
				$node->isLazy = true;
				$node->hideCheckbox = true;
			} else {
			
				if (in_array($category['Content']['id'], $related) && ((int)$products_id != $category['Content']['id'])) {
					$node->select = true;
				}

				if ((int)$products_id == $category['Content']['id']) {
					$node->hideCheckbox = true;
				}
			}

			$node->key = $category['Content']['id'];
			$node->products_id = (int)$products_id;

			$nodes[] = $node;
		}

		$this->set('content_data', $nodes);
	}

	public function admin_set_relation($products_id, $related_id, $relation)
	{
		$products_id = (int)$products_id;
		$related_id = (int)$related_id;
		$relation = (int)$relation;

		$content = $this->Content->find('first', array('conditions' => array('Content.id' => $products_id)));

		if ($relation) {
			$content['xsell'][] = array('related_id' => $related_id);
			$this->Content->save($content);
		} else {
			$this->Content->query("DELETE FROM contents_contents WHERE product_id=" . $products_id . " and related_id=" . $related_id);
		}

		
	}

	public function _add_tree_node($tree, $node, $level)
	{
		$tree[] = array('id' => $node['Content']['id'],
				'name' => $node['ContentDescription']['name'],
				'level' => $level,
				'tree_prefix' => str_repeat('&nbsp;&nbsp;', $level));
				
		foreach ($node['children'] as $child) {
			$this->_add_tree_node($tree, $child, $level + 1);
		}
	}
	
	public function _copy_content($content, $parent_id)
	{
		$content['Content']['id'] = null;
		$content['Content']['parent_id'] = $parent_id;
		$content['Content']['viewed'] = 0;
		
		$this->Content->create();
		$this->Content->save($content['Content']);
		$content_id = $this->Content->getLastInsertid();
		
		foreach ($content['ContentDescription'] as $description)
		{
			$description['id'] = null;
			$description['content_id'] = $content_id;
			$this->Content->ContentDescription->create();
			$this->Content->ContentDescription->save($description);
		}
		
		$model = $content['ContentType']['type'];
		
		$content[$model]['id'] = null;
		$content[$model]['content_id'] = $content_id;
		
		if ('ContentProduct' == $model) {
			$content[$model]['ordered'] = 0;
		}
		
		$this->Content->$model->create();
		$this->Content->$model->save($content[$model]);
		
		$this->_copy_content_images($content, $content_id);
	}
	
	public function _copy_content_images($content, $dst_content_id)
	{
		foreach ($content['ContentImage'] as $image) {
			$src_filename = WWW_ROOT . IMAGES_URL . '/content/' . $image['content_id'] . '/' . $image['image'];
			$dst_filename = WWW_ROOT . IMAGES_URL . '/content/' . $dst_content_id . '/' . $image['image'];
			$dst_dir = WWW_ROOT . IMAGES_URL . '/content/' . $dst_content_id;
			
			if(!is_dir($dst_dir)) {
				@mkdir($dst_dir);
			}
			
			@copy($src_filename, $dst_filename);
			
			$image['id'] = null;
			$image['content_id'] = $dst_content_id;
			
			$this->Content->ContentImage->create();
			$this->Content->ContentImage->save($image);
		}
	}

	public function _random_string()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < 16; $i++) {
			$randstring .= mb_substr($characters, rand(0, strlen($characters) - 1), 1);
		}
		return $randstring;
	}
}
?>