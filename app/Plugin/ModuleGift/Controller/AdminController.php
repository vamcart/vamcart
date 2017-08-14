<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class AdminController extends ModuleGiftAppController {
	public $helpers = array('Time','Admin');
	public $components = array('ContentBase');
	public $uses = array('PaymentMethod', 'ModuleGift', 'Content');

	public function admin_delete($id)
	{
		$this->ModuleGift->delete($id);
		$this->Session->setFlash(__d('module_gift', 'You have deleted a gift.'));
		$this->redirect('/module_gift/admin/admin_index/');
	}
	
	public function admin_edit($id = null)
	{
		if(empty($this->data))
		{
			$this->set('current_crumb', __d('module_gift', 'Gift Edit'));
			$this->set('title_for_layout', __d('module_gift', 'Gift Edit'));

			$this->request->data = $this->ModuleGift->read(null,$id);

		}
		else
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/module_gift/admin/admin_index/');
				die();
			}
			
			$this->ModuleGift->save($this->data);
			$this->Session->setFlash(__d('module_gift', 'You have saved a gift.'));
			
			if($id == null)
				$id = $this->ModuleGift->getLastInsertId();
			
			if(isset($this->data['applybutton']))
				$this->redirect('/module_gift/admin/admin_edit/' . $id);		
			else
				$this->redirect('/module_gift/admin/admin_index/');
		
		}
	}
	
	public function admin_new()
	{
		$this->redirect('/module_gift/admin/admin_edit/');
	}
	
	public function admin_index()
	{
		$this->set('current_crumb', __d('module_gift', 'Gifts'));
		$this->set('title_for_layout', __d('module_gift', 'Manage Gifts'));

		$data = $this->ModuleGift->find('all');
		
    	foreach($data AS $key => $value)
    	{
        $content_description = $this->ContentBase->get_content_description($data[$key]['ModuleGift']['content_id']);
        $data[$key]['ModuleGift']['product_name'] = $content_description['ContentDescription']['name'];
      }

		$this->set('gifts',$data);


	}
	
	public function admin_help()
	{
		$this->set('current_crumb', __d('module_gift', 'Gifts'));
		$this->set('title_for_layout', __d('module_gift', 'Gifts'));
	}

	public function admin_products_tree()
	{
		
		$this->Content->unbindAll();
		
		$this->Content->bindModel(array('hasOne' => array(
								'ContentDescription' => array(
									'className' => 'ContentDescription',
									'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
									)
								)
						)
		);
		
		$categories_query = $this->Content->find('all', array('conditions' => array('Content.active' => 1, 'Content.content_type_id' => 2)));
		$parents = array();
		foreach ($categories_query as $parent) {
			$this->_add_tree_node($parents, $parent, 0);
		}
		
		$parents_list = array();
		foreach ($parents as $status) {
			$parents_list[$status['id']] = $status['tree_prefix'].$status['name'];
		}
		
		return $parents_list;
	}
	
	public function _add_tree_node(&$tree, $node, $level)
	{
		$tree[] = array('id' => $node['Content']['id'],
				'name' => $node['ContentDescription']['name'],
				'level' => $level,
				'tree_prefix' => str_repeat('&nbsp;&nbsp;', $level));
				
		foreach ($node['children'] as $child) {
			$this->_add_tree_node($tree, $child, $level + 1);
		}
	}
		
}

?>