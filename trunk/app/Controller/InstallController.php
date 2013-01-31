<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class InstallController extends AppController {
	public $name = 'Install';
	public $uses = null;
	public $components = array('Install');


	public function parse_mysql_dump($url, $ignoreerrors = false) 
	{
		$file_content = file($url);
		//pr($file_content);
	
	 	$query = "";
		foreach($file_content as $sql_line) {
			$tsl = trim($sql_line);
			if (($sql_line != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "#")) 
			{
				$query .= $sql_line;
	       		if(preg_match("/;\s*$/", $sql_line)) 
				{
	         		$result = mysql_query($query);
	         		if (!$result && !$ignoreerrors) die(mysql_error());
	         		$query = "";
	       		}
	     	}
		}
	}
		
	public function index ()
	{
		$this->redirect('/install/start/');
	}
	
	public function check_permissions ()
	{
		// Check if required files/directories are writable.
		$dirs_to_check = array(
		ROOT . DS . 'config.php', 
		WWW_ROOT . 'version.txt', 
		WWW_ROOT . 'sxd/', 
		WWW_ROOT . 'sxd/backup', 
		WWW_ROOT . 'sxd/ses.php', 
		WWW_ROOT . 'sxd/cfg.php', 
		TMP, 
		CACHE, 
		TMP . 'updates/', 
		TMP . 'modules/');
		$install_checks = array();
		
		foreach($dirs_to_check AS $dir)
		{
			$this_check = array();
			if(is_writable($dir))
			{
				$this_check['passed'] = 'passed';
			}
			else
			{
				$this_check['passed'] = 'failed';
				$this->set('fatal_error','1');
			}
			$this_check['dir'] = $dir;
			
			$install_checks[] = $this_check;
		}
		
		$this->set('install_checks',$install_checks);	
	}
	
	public function start ()
	{	
		$this->layout = 'default';
		$this->set('current_crumb', __('Install VamCart', true));
		$this->set('title_for_layout', __('Install VamCart', true));
		$this->set('version',$this->Install->getVersion());
		
		$values = array();
		
		if(!empty($this->data))
		{
			$values['Install']['db_host'] = $this->data['Install']['db_host'];
			$values['Install']['db_username'] = $this->data['Install']['db_username'];
			$values['Install']['db_password']  = $this->data['Install']['db_password'];
			$values['Install']['db_name'] = $this->data['Install']['db_name'];
		}
		else
		{
			$values['Install']['db_host'] = 'localhost';
			$values['Install']['db_username'] = 'root';
			$values['Install']['db_password']  = '';
			$values['Install']['db_name'] = 'vamcart';
		}	
		$this->set('values',$values);
	}
	
	
	public function create ()
	{
		$this->layout = 'default';

		$this->set('current_crumb', __('VamCart Installed', true));
		$this->set('title_for_layout', __('VamCart Installed', true));
		
		$username = $this->data['Install']['db_username'];
		$password = $this->data['Install']['db_password'];
		$hostname = $this->data['Install']['db_host'];	
		
		// Attempt to connect to the database
		if(!$dbh = mysql_connect($hostname, $username, $password) )
		{
			$this->Session->setFlash(__('Unable to connect to database.',true));
			$error = 1;
		}

		// Attempt to select the database
		if(!$selected = mysql_select_db($this->data['Install']['db_name'],$dbh))
		{
			$this->Session->setFlash(__('Could not select database. Are you sure you created it?',true));
			$error = 1;
		}
			
		// Attempt to open the config file
		if(!$fh = fopen(ROOT . '/config.php', 'w'))
		{
			$this->Session->setFlash(__('Can\'t open config.php. Please check you have proper permissions to write to that file.',true));
			$error = 1;
		}

		// Send them back to the install script if an error was received.		
		if(isset($error))
		{
			$this->redirect('/install/');
			die();		
		}
		
		$configData = '<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class DATABASE_CONFIG {

	public $default = array(
		\'datasource\' => \'Database/Mysql\',
		\'persistent\' => false,
		\'host\' => \'' . $this->data['Install']['db_host'] . '\',
		\'login\' => \'' . $this->data['Install']['db_username'] . '\',
		\'password\' => \'' . $this->data['Install']['db_password'] . '\',
		\'database\' => \'' . $this->data['Install']['db_name'] . '\',
		\'prefix\' => \'\',
		\'encoding\' => \'utf8\' 
	);

}
?>';
		
		fwrite($fh, $configData);
		fclose($fh);
	
			
		$file = ROOT . '/app/install_schemas/database.sql';
		$this->parse_mysql_dump($file);

	}
}
?>