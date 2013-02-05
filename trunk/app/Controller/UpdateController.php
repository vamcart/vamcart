<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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
		} else {            $this->data->versions = $this->Check->get_list_update_version($this->data->current_version);
            $this->data->versions = explode(';',$this->data->versions);
            $this->data->current_version = '';
            foreach($this->data->versions as $version) {            	$this->Check->get_update_archive($version);
        		App::import('Vendor', 'PclZip', array('file' => 'pclzip'.DS.'zip.php'));
				$this->data->zip_dir = basename($version);
            	if(!@mkdir('../tmp/updates/'.$this->data->zip_dir, 0777))
					die("<font color='red'>Error : Unable to create directory</font><br />");
				$this->data->archive = new PclZip('../tmp/updates/'.$version.'.zip');
				if ($this->data->archive->extract(PCLZIP_OPT_PATH,'../tmp/updates/'.$this->data->zip_dir) == 0)
					die("<font color='red'>Error : Unable to unzip archive</font>");
                $this->data->description = file_get_contents('../tmp/updates/'.$this->data->zip_dir.'/description.xml');
                $this->data->description = $this->Check->xml2array($this->data->description);
                if(isset($this->data->description['files']['file']['value']) && $this->data->description['files']['file']['value'] != '') {                	$this->data->tmp[0]['value'] = $this->data->description['files']['file']['value'];
                	$this->data->tmp[0]['attr'] = $this->data->description['files']['file']['attr'];
                	$this->data->description['files']['file'] = $this->data->tmp;
                }


                if(count($this->data->description['files']['file']) > 0) {                	foreach($this->data->description['files']['file'] as $file) {						if($file['attr']['action'] == 'create')							copy('../tmp/updates/'.$this->data->zip_dir.$file['attr']['path'].$file['value'], '../..'.$file['attr']['path'].$file['value']);
							//chmod('../..'.$file['attr']['path'].$file['value'],0755);
						if($file['attr']['action'] == 'update') {							@unlink('../..'.$file['attr']['path'].$file['value']);
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
			fclose($handle);         	$this->set('success','1');
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
}
?>