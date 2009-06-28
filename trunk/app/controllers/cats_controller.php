<?php
class CatsController extends AppController {
	var $name = 'Cats';
   var $helpers = array('Html', 'Javascript');
   var $components = array('Lang','Config');

    var $paginate = array(
        'limit' => 5,
        'order' => array(
            'Cat.id' => 'desc'
        )
    );

	function index() {
//		$this->set('cats', $this->Cat->find('all'));
	   $data = $this->paginate('Cat');
      $this->set('cats', $data);
		$this->pageTitle = __('Title',true);
	}

	function view($id) {
		$this->Cat->id = $id;
		$this->set('cat', $this->Cat->read());

	}

	function add() {
			$this->set('language',$this->Lang->load_language());	
		if (!empty($this->data)) {
			if ($this->Cat->save($this->data)) {
				$this->Session->setFlash(__('Your category has been saved.',true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}
function delete($id) {
	$this->Cat->del($id);
	$this->Session->setFlash(__('The category with id: '.$id.' has been deleted.',true));
	$this->redirect(array('action'=>'index'));
}
function edit($id = null) {
	$this->Cat->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Cat->read();
	} else {
		if ($this->Cat->save($this->data)) {
			$this->Session->setFlash(__('Your category id: '.$id.' has been updated.',true));
			$this->redirect(array('action' => 'index'));
		}
	}
}	
}
?>