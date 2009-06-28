<?php
class PostsController extends AppController {
	var $name = 'Posts';
   var $helpers = array('Html', 'Javascript');
   var $components = array('Lang','Config');

    var $paginate = array(
        'limit' => 5,
        'order' => array(
            'Post.id' => 'desc'
        )
    );

	function index() {
//		$this->set('posts', $this->Post->find('all'));
	   $data = $this->paginate('Post');
      $this->set('posts', $data);
		$this->pageTitle = __('Title',true);
	}

	function view($id) {
		$this->Post->id = $id;
		$this->set('post', $this->Post->read());

	}

	function add() {
			$this->set('language',$this->Lang->load_language());	
		if (!empty($this->data)) {
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash(__('Your post has been saved.',true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}
function delete($id) {
	$this->Post->del($id);
	$this->Session->setFlash(__('The post with id: '.$id.' has been deleted.',true));
	$this->redirect(array('action'=>'index'));
}
function edit($id = null) {
	$this->Post->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Post->read();
	} else {
		if ($this->Post->save($this->data)) {
			$this->Session->setFlash(__('Your post id: '.$id.' has been updated.',true));
			$this->redirect(array('action' => 'index'));
		}
	}
}	
}
?>