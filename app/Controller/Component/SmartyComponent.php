<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class SmartyComponent extends Component
{
	private $smarty;
    
	public function beforeFilter () {
	}
	
	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller, $url, $status = NULL, $exit = true){
	}
	
	public function load_template ($params, $tag)
	{
		if(isset($params['template'])) {
			// Cache the output.
			$cache_name = 'vam_plugin_template_' .  $params['template'];
			$output = Cache::read($cache_name, 'catalog');
			if ($output === false) {
				ob_start();

				App::import('Model', 'MicroTemplate');
				$MicroTemplate = new MicroTemplate();

				$template = $MicroTemplate->find('first', array('conditions' => array('alias' => $params['template'])));
				$display_template = $template['MicroTemplate']['template'];

				// Minify html                	
				//if (Configure::read('debug') == 0) $display_template = str_replace(array("\n","\r","\t"),'',$display_template);

				echo $display_template;

				// End of cache
				$output = @ob_get_contents();
				ob_end_clean();
				Cache::write($cache_name, $output, 'catalog');
			}
			$display_template = $output;
		} else {
			$display_template_function = 'default_template_' . $tag;
			$display_template = $display_template_function();
		}

		return $display_template;
	}

	public function load_smarty ()
	{
            if(!isset($this->smarty)) {
		App::import('Vendor', 'Smarty', array('file' => 'smarty'.DS.'Smarty.class.php'));
		$this->smarty = new Smarty();

		$this->smarty->plugins_dir = array(
			APP . 'Vendor/smarty/plugins',
			APP . 'Catalog/local',
			APP . 'Catalog'
		);

		// Minify html
		if (Configure::read('debug') == 0) $this->smarty->loadFilter('output','minify_html');

		$this->smarty->setCacheDir(CACHE . 'smarty_cache');
		$this->smarty->setCompileDir(CACHE . 'smarty_templates_c');
            }
		return $this->smarty;
	}

	public function fetch($str, $assigns = array())
	{
		$this->smarty = $this->load_smarty();

		foreach($assigns AS $key => $value) {
			$this->smarty->assign($key, $value);
		}

		return $this->smarty->fetch('string:' . $str);
	}

	public function display($str, $assigns = array())
	{
		echo $this->fetch($str, $assigns);
	}
}
?>
