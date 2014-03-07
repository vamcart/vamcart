<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class InstallController extends AppController {
	public $name = 'Install';
	public $uses = null;
	public $components = array('Install');


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
		WWW_ROOT . 'css/', 
		WWW_ROOT . 'js/', 
		WWW_ROOT . 'files/', 
		WWW_ROOT . 'img/', 
		WWW_ROOT . 'img/content/', 
		TMP, 
		CACHE, 
		CACHE . DS . 'catalog', 
		CACHE . DS . 'smarty_cache', 
		CACHE . DS . 'smarty_templates_c', 
		TMP . 'updates', 
		TMP . 'modules');
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
		$this->set('current_crumb', __('Install VamShop', true));
		$this->set('title_for_layout', __('Install VamShop', true));
		$this->set('version',$this->Install->getVersion());
		
		$values = array();
		
		if(!empty($this->data))
		{
			$values['Install']['db_host'] = $this->data['Install']['db_host'];
			$values['Install']['db_username'] = $this->data['Install']['db_username'];
			$values['Install']['db_password']  = $this->data['Install']['db_password'];
			$values['Install']['db_name'] = $this->data['Install']['db_name'];
			$values['Install']['username'] = $this->data['Install']['username'];
			$values['Install']['email'] = $this->data['Install']['email'];
			$values['Install']['password'] = $this->data['Install']['password'];
		}
		else
		{
			$values['Install']['db_host'] = 'localhost';
			$values['Install']['db_username'] = 'root';
			$values['Install']['db_password']  = '';
			$values['Install']['db_name'] = 'vamshop';
			$values['Install']['username'] = 'admin';
			$values['Install']['email'] = 'admin@vamshop.loc';
			$values['Install']['password'] = 'password';
		}	
		$this->set('values',$values);
	}
	
	
	public function create ()
	{
		$this->layout = 'default';

		$this->set('current_crumb', __('VamShop Installed', true));
		$this->set('title_for_layout', __('VamShop Installed', true));
		
		$username = $this->data['Install']['db_username'];
		$password = $this->data['Install']['db_password'];
		$hostname = $this->data['Install']['db_host'];	
		$database = $this->data['Install']['db_name'];	
		$admin_username = $this->data['Install']['username'];	
		$admin_email = $this->data['Install']['email'];	
		$admin_password = $this->data['Install']['password'];	
		
		// Attempt to connect to the database
		
		$dbh = mysqli_connect($hostname, $username, $password, $database);
		
		if(!$dbh)
		{
			$this->Session->setFlash(__('Unable to connect to database.',true));
			$error = 1;
		}

	   @mysqli_query($dbh, "SET SQL_MODE= ''");
	   @mysqli_query($dbh, "SET SQL_BIG_SELECTS=1");
	   @mysqli_query($dbh, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
		
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
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
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

		$file_content = file($file);
		//pr($file_content);
	
	 	$query = "";
	 	$ignoreerrors = false;
		foreach($file_content as $sql_line) {
			$tsl = trim($sql_line);
			if (($sql_line != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "#")) 
			{
				$query .= $sql_line;
	       		if(preg_match("/;\s*$/", $sql_line)) 
				{
	         		$result = mysqli_query($dbh, $query);
	         		if (!$result && !$ignoreerrors) die(mysqli_error($dbh));
	         		$query = "";
	       		}
	     	}
		}
		
	   @mysqli_query($dbh, 'update users set username = "' . trim(stripslashes($admin_username)) . '", email = "' . trim(stripslashes($admin_email)) . '", password = "' . Security::hash(trim(stripslashes($admin_password)), 'sha1', true) . '", created = "now()", modified = "now()" where id = "1"');
		

	}
}
?>