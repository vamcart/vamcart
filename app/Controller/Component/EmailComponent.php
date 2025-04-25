<?php
/**
* This is a component to send email from CakePHP using PHPMailer
* @link http://bakery.cakephp.org/articles/view/94
* @see http://bakery.cakephp.org/articles/view/94
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailComponent extends CakeObject
{     

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
	
    /**
     * PHPMailer object.
     * 
     * @access private
     * @var object
     */
     public $m;    
    
    /**
     * Creates the PHPMailer object and sets default values.
     * Must be called before working with the component!
     *
     * @access public
     * @return void
     */
    public function init()
    {
    	
        $this->m = new PHPMailer;
        
        // Set default PHPMailer variables (see PHPMailer API for more info)
		
			$this->IsMail();
		
			$this->CharSet = 'utf-8';
			$this->IsHTML(true);

			//DKIM Settings
		
			//$this->DKIM_domain = 'your-store.com';
			//$this->DKIM_private = '/path/to/private/key';
			//$this->DKIM_selector = 'phpmailer';
			//$this->DKIM_passphrase = '12345';
			//$this->DKIM_identity = 'your@email.com';

			// set more PHPMailer vars, for smtp etc.

			//$this->IsSMTP();
			//$this->SMTPKeepAlive = true; // set mailer to use SMTP			//$this->SMTPAuth = true; // turn on SMTP authentication true/false			//$this->Username = user; // SMTP username			//$this->Password = password; // SMTP password			//$this-> = server; // specify smtp server		
     }

    public function __set($name, $value)
    {
        $this->m->{$name} = $value;
    }
    
    public function __get($name)
    {
        if (isset($this->m->{$name})) {
            return $this->m->{$name};
        }
    }
             
    public function __call($method, $args)
    {
        if (method_exists($this->m, $method)) {
            return call_user_func_array(array($this->m, $method), $args);
        }
    }
}
?>