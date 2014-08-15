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

	public function xml2array($contents, $get_attributes=1) {
		if(!$contents) return array();
		if(!function_exists('xml_parser_create')) {
			return array();
		}
		//Get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create();
		xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
		xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
		xml_parse_into_struct( $parser, $contents, $xml_values );
		xml_parser_free( $parser );

if(!$xml_values) return;//Hmm...

//Initializations
$xml_array = array();
$parents = array();
$opened_tags = array();
$arr = array();

$current = &$xml_array;

//Go through the tags.
foreach($xml_values as $data) {
unset($attributes,$value);//Remove existing values, or there will be trouble

//This command will extract these variables into the foreach scope
// tag(string), type(string), level(int), attributes(array).
extract($data);//We could use the array by itself, but this cooler.

$result = '';
if($get_attributes) {//The second argument of the public function decides this.
$result = array();
if(isset($value)) $result['value'] = $value;

//Set the attributes too.
if(isset($attributes)) {
foreach($attributes as $attr => $val) {
if($get_attributes == 1) $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
/** :TODO: should we change the key name to '_attr'? Someone may use the tagname 'attr'. Same goes for 'value' too */
}
}
} elseif(isset($value)) {
$result = $value;
}

//See tag status and do the needed.
if($type == "open") {//The starting of the tag "
$parent[$level-1] = &$current;

if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
$current[$tag] = $result;
$current = &$current[$tag];

} else { //There was another element with the same tag name
if(isset($current[$tag][0])) {
array_push($current[$tag], $result);
} else {
$current[$tag] = array($current[$tag],$result);
}
$last = count($current[$tag]) - 1;
$current = &$current[$tag][$last];
}

} elseif($type == "complete") { //Tags that ends in 1 line "
//See if the key is already taken.
if(!isset($current[$tag])) { //New Key
$current[$tag] = $result;

} else { //If taken, put all things inside a list(array)
if((is_array($current[$tag]) and $get_attributes == 0)//If it is already an array…
or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1)) {
array_push($current[$tag],$result); // …push the new element into that array.
} else { //If it is not an array…
$current[$tag] = array($current[$tag],$result); //…Make it an array using using the existing value and the new value
}
}

} elseif($type == 'close') { //End of tag "
$current = &$parent[$level-1];
}
}

return($xml_array);
}

}
?>