<?php
class PagesController extends AppController {
	var $name = 'Pages';
   var $helpers = array('Html', 'Javascript');
   var $components = array('Lang','Config');

    var $paginate = array(
        'limit' => 5,
        'order' => array(
            'Page.id' => 'desc'
        )
    );

	function index() {
//		$this->set('pages', $this->Page->find('all'));
	   $data = $this->paginate('Page');
      $this->set('pages', $data);
		$this->pageTitle = __('Title',true);
	}

	function view($id) {
		$this->Page->id = $id;
		$this->set('page', $this->Page->read());

	}

	function add() {
			$this->set('language',$this->Lang->load_language());	
		if (!empty($this->data)) {
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('Your page has been saved.',true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}
function delete($id) {
	$this->Page->del($id);
	$this->Session->setFlash(__('The page with id: '.$id.' has been deleted.',true));
	$this->redirect(array('action'=>'index'));
}
function edit($id = null) {
	$this->Page->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Page->read();
	} else {
		if ($this->Page->save($this->data)) {
			$this->Session->setFlash(__('Your page id: '.$id.' has been updated.',true));
			$this->redirect(array('action' => 'index'));
		}
	}
}	
}
?>