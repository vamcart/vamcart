<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class CheckComponent extends Object
{
    public $data;

	public function beforeFilter ()
	{
	}

	public function initialize(Controller $controller) {
	}
    
	public function shutdown(Controller $controller) {
	}

	public function beforeRedirect(Controller $controller){
	}
    
	public function beforeRender(Controller $controller){
	}

   public function startup(Controller $controller)
	{
   }

    public function check()
    {

    }

    public function get_info()
    {
		App::import('Model', 'License');
	   $License =& new License();
    	$this->data = $License->find('first');
     	if($this->check_domain($this->data['License']['licenseKey']) != 'true') {
    	
		$config_filename = ROOT . '/config.php';
		if(is_readable($config_filename)) {
			if (filesize($config_filename) > 0) {
				$demo_period = 14;
    			$current_install = date("d", filemtime($config_filename));  
    			if ($current_install <= $demo_period) {
				
    			} else {
    			echo __('Trial version of VamShop is over. Purchase unlimited version of VamShop at') . ' <a href="'. 'http://' . __('vamshop.com') . '">http://' . __('vamshop.com') . '</a>';
    			die();
    			}
    		}
    	}
    	} else {
    	}
    }

	public function get ($licenseID)
	{
    	$host = $this->check_host();
        if(strpos($host,'www.') !== FALSE) $host = str_replace('www.','',$host);
    	return file_get_contents(CheckServer.'check/'.$licenseID.'/'.$host);
	}

	public function check_domain ($licenseID)
	{
    	$host = $this->check_host();
		if(strpos($host,'www.') !== FALSE) $host = str_replace('www.','',$host);
		$cache_file = CACHE . 'persistent' . DS . $host;
		if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 7 * 24 * 60 * 60 ))) {
			$domain = file_get_contents($cache_file);
		} else {
			$domain = file_get_contents(CheckServer.'check/domain/'.$licenseID.'/'.$host);
			file_put_contents($cache_file, $domain, LOCK_EX);
		}
		
		if ($domain == '') $domain = 'false';	
		
    	return $domain;
	}

	public function get_latest_update_version()
	{
    	$host = $this->check_host();
        if(strpos($host,'www.') !== FALSE) $host = str_replace('www.','',$host);
			App::import('Model', 'License');
	    	$License =& new License();
   	     $this->data = $License->find('first');
    	return file_get_contents(CheckServer.'check/update/'.$this->data['License']['licenseKey'].'/'.$host);
	}

	public function get_list_update_version($current_version)
	{
    	$host = $this->check_host();
        if(strpos($host,'www.') !== FALSE) $host = str_replace('www.','',$host);
			App::import('Model', 'License');
	   	$License =& new License();
			$this->data = $License->find('first');
    	return file_get_contents(CheckServer.'check/update/list/'.$this->data['License']['licenseKey'].'/'.$host.'/'.$current_version);
	}

	public function get_update_archive($version)
	{
		$host = $this->check_host();
		if(strpos($host,'www.') !== FALSE) $host = str_replace('www.','',$host);
		App::import('Model', 'License');
    	$License =& new License();
		$this->data = $License->find('first');
		$origFileName = '../tmp/updates/'.$version.'.zip';

		$fp = @fopen(CheckServer.'check/update/get/'.$this->data['License']['licenseKey'].'/'.$host.'/'.$version, 'rb');
		$fd = @fopen($origFileName, 'w');
		if ($fp && $fd) {
			while (!feof($fp)) {
				$st = fread($fp, 4096);
				fwrite($fd, $st);
			}
		}
		@fclose($fp);
		@fclose($fd);
	}

	public function check_host()
	{
		$host = $host1 = $_SERVER['HTTP_HOST'];
		$host2 = getenv('HTTP_HOST');
		if(function_exists('apache_getenv'))
			$host3 = apache_getenv('HTTP_HOST');
		else
			$host3 = $host1;

		if(!($host1 == $host2 && $host1 == $host3))
			return false;
		else
			return $host;
	}

}
?>