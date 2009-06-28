<?php
class CategoriesController extends AppController {
	var $name = 'Categories';
   var $helpers = array('Html', 'Javascript');
   var $components = array('Lang','Config');

    var $paginate = array(
        'limit' => 5,
        'order' => array(
            'Categorie.id' => 'desc'
        )
    );

	function index() {
//		$this->set('categories', $this->Categorie->find('all'));
	   $data = $this->paginate('Categorie');
      $this->set('categories', $data);
		$this->pageTitle = __('Title',true);
	}

	function view($id) {
		$this->Categorie->id = $id;
		$this->set('categorie', $this->Categorie->read());

	}

	function add() {
			$this->set('language',$this->Lang->load_language());	
		if (!empty($this->data)) {
			if ($this->Categorie->save($this->data)) {
				$this->Session->setFlash(__('Your categorie has been saved.',true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}
function delete($id) {
	$this->Categorie->del($id);
	$this->Session->setFlash(__('The categorie with id: '.$id.' has been deleted.',true));
	$this->redirect(array('action'=>'index'));
}
function edit($id = null) {
	$this->Categorie->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Categorie->read();
	} else {
		if ($this->Categorie->save($this->data)) {
			$this->Session->setFlash(__('Your categorie id: '.$id.' has been updated.',true));
			$this->redirect(array('action' => 'index'));
		}
	}
}	
}
?>