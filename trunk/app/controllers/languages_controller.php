<?php
class LanguagesController extends AppController {
	var $name = 'Languages';
   var $helpers = array('Html', 'Javascript');
   var $components = array('Config');

	function index() {
		$this->set('languages', $this->Language->find('all'));
		$this->pageTitle = __('Title',true);
	}

	function view($id) {
		$this->Language->id = $id;
		$this->set('language', $this->Language->read());

	}

	function add() {
		if (!empty($this->data)) {
			if ($this->Language->save($this->data)) {
				$this->Session->setFlash(__('Your Language has been saved.',true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}
function delete($id) {
	$this->Language->del($id);
	$this->Session->setFlash(__('The Language with id: '.$id.' has been deleted.',true));
	$this->redirect(array('action'=>'index'));
}
function edit($id = null) {
	$this->Language->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Language->read();
	} else {
		if ($this->Language->save($this->data)) {
			$this->Session->setFlash(__('Your Language id: '.$id.' has been updated.',true));
			$this->redirect(array('action' => 'index'));
		}
	}
}	
}
?>