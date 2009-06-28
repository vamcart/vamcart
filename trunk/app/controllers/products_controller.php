<?php
class ProductsController extends AppController {
	var $name = 'Products';
   var $helpers = array('Html', 'Javascript');
   var $components = array('Lang','Config');

    var $paginate = array(
        'limit' => 5,
        'order' => array(
            'Product.id' => 'desc'
        )
    );

	function index() {
//		$this->set('products', $this->Product->find('all'));
	   $data = $this->paginate('Product');
      $this->set('products', $data);
		$this->pageTitle = __('Title',true);
	}

	function view($id) {
		$this->Product->id = $id;
		$this->set('product', $this->Product->read());

	}

	function add() {
			$this->set('language',$this->Lang->load_language());	
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('Your product has been saved.',true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}
function delete($id) {
	$this->Product->del($id);
	$this->Session->setFlash(__('The product with id: '.$id.' has been deleted.',true));
	$this->redirect(array('action'=>'index'));
}
function edit($id = null) {
	$this->Product->id = $id;
	if (empty($this->data)) {
		$this->data = $this->Product->read();
	} else {
		if ($this->Product->save($this->data)) {
			$this->Session->setFlash(__('Your product id: '.$id.' has been updated.',true));
			$this->redirect(array('action' => 'index'));
		}
	}
}	
}
?>