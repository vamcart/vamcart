<?php
class ConfigComponent extends Object {
  var $name = 'Config';
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
		$this->load_configuration();
	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {
	}

	//called after Controller::beforeRender()
	function beforeRender(&$controller) {
	}

	//called after Controller::render()
	function shutdown(&$controller) {
	}

	//called before Controller::redirect()
	function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
	}

	function redirectSomewhere($value) {
		// utilizing a controller method
		$this->controller->redirect($value);
	}

	function load_configuration ()
	{
			Classregistry::init('Configuration');
			$this->Configuration =& new Configuration();

			$configuration = $this->Configuration->find('all');

		   foreach ($configuration as $option):
		     Configure::write('Config.'.$option['Configuration']['configuration_key'],$option['Configuration']['configuration_value']);
		   endforeach;

	}	

}
?>