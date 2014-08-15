<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
set_time_limit(3600);

class UpdateController extends AppController {
	public $name = 'Update';
	public $components = array('Check');	
	public $data;

	public function admin_update($ajax_request = false)
	{
		$this->data->current_version = file_get_contents('./version.txt');
		$this->data->latest_version = $this->Check->get_latest_update_version();

     	$this->set('error','0');
     	$this->set('success','0');
		$templine = '';

			$this->set('current_crumb', __('Update', true));
			$this->set('title_for_layout', __('Update', true));

		if($this->data->current_version >= $this->data->latest_version) {
			$this->set('error','1');
		} else {
            $this->data->versions = $this->Check->get_list_update_version($this->data->current_version);
            $this->data->versions = explode(';',$this->data->versions);
            $this->data->current_version = '';
            foreach($this->data->versions as $version) {
            	$this->Check->get_update_archive($version);
        		App::import('Vendor', 'PclZip', array('file' => 'pclzip'.DS.'zip.php'));
				$this->data->zip_dir = basename($version);
            	if(!@mkdir('../tmp/updates/'.$this->data->zip_dir, 0777))
					die("<font color='red'>Error : Unable to create directory</font><br />");
				$this->data->archive = new PclZip('../tmp/updates/'.$version.'.zip');
				if ($this->data->archive->extract(PCLZIP_OPT_PATH,'../tmp/updates/'.$this->data->zip_dir) == 0)
					die("<font color='red'>Error : Unable to unzip archive</font>");
                $this->data->description = file_get_contents('../tmp/updates/'.$this->data->zip_dir.'/description.xml');
                $this->data->description = $this->xml2array($this->data->description);
                if(isset($this->data->description['files']['file']['value']) && $this->data->description['files']['file']['value'] != '') {
                	$this->data->tmp[0]['value'] = $this->data->description['files']['file']['value'];
                	$this->data->tmp[0]['attr'] = $this->data->description['files']['file']['attr'];
                	$this->data->description['files']['file'] = $this->data->tmp;
                }


                if(count($this->data->description['files']['file']) > 0) {
                	foreach($this->data->description['files']['file'] as $file) {
						if($file['attr']['action'] == 'create')
							copy('../tmp/updates/'.$this->data->zip_dir.$file['attr']['path'].$file['value'], '../..'.$file['attr']['path'].$file['value']);
							//chmod('../..'.$file['attr']['path'].$file['value'],0755);
						if($file['attr']['action'] == 'update') {
							@unlink('../..'.$file['attr']['path'].$file['value']);
							@copy('../tmp/updates/'.$this->data->zip_dir.$file['attr']['path'].$file['value'], '../..'.$file['attr']['path'].$file['value']);
							//chmod('../..'.$file['attr']['path'].$file['value'],0755);
						}
						if($file['attr']['action'] == 'delete')
							@unlink('../..'.$file['attr']['path'].$file['value']);
                        if($file['attr']['action'] == 'sql') {
							$lines = file('../tmp/updates/'.$this->data->zip_dir.'/'.$file['value']);
							foreach ($lines as $line) {
    							if (substr($line, 0, 2) == '--' || $line == '')
        						continue;
								$templine .= $line;
								if (substr(trim($line), -1, 1) == ';') {
									$this->Update->query($templine);
									$templine = '';
								}
							}
						}
                	}
                }
      		App::import('Vendor', 'DeleteAll', array('file' => 'deleteall'.DS.'deleteall.php'));    
      		@deleteAll('../tmp/updates/'.$this->data->zip_dir);
      		@unlink('../tmp/updates/'.$version.'.zip');
      		$this->data->current_version = $version;
            }
            $filename = './version.txt';
			$handle = fopen($filename, 'w+');
			fwrite($handle, $this->data->current_version);
			fclose($handle);
         	$this->set('success','1');
		}
	}

	public function admin($ajax_request = false)
	{
  		$this->set('current_crumb', __('Update', true));
		$this->set('title_for_layout', __('Update', true));
		$this->data->current_version = file_get_contents('./version.txt');
		$this->data->latest_version = $this->Check->get_latest_update_version();
		$this->set('update_data',$this->data);
	}
	
	private function xml2array($contents, $get_attributes=1) {
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