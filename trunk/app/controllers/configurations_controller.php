<?php
class ConfigurationsController extends AppController {
	var $name = 'Configurations';
   var $helpers = array('Html', 'Javascript');
   var $components = array('Config');

	function index() {
		$this->set('configurations', $this->Configuration->find('all'));
		$this->pageTitle = __('Configuration',true);
	}

	function add() {
		if (!empty($this->data)) {
			if ($this->Configuration->save($this->data)) {
				$this->Session->setFlash(__('Your Configuration has been saved.',true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}

function edit($id = null) {
	$this->Configuration->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Configuration->read();
	} else {
		if ($this->Configuration->save($this->data)) {
			$this->Session->setFlash(__('Your Configuration id: '.$id.' has been updated.',true));
			$this->redirect(array('action' => 'index'));
		}
	}
}	
}
?>