<?php
/**
* This is a component to send email from CakePHP using PHPMailer
* @link http://bakery.cakephp.org/articles/view/94
* @see http://bakery.cakephp.org/articles/view/94
*/

class EmailComponent extends Object
{     

   public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller){
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
        // Include the class file and create PHPMailer instance
        App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer'.DS.'class.phpmailer.php'));
        $this->m = new PHPMailer;
        
        // Set default PHPMailer variables (see PHPMailer API for more info)
		
		$this->IsMail();
		
		$this->CharSet = 'utf-8';
		// set more PHPMailer vars, for smtp etc.
//		$this->IsSMTP();
//		$this->SMTPKeepAlive = true; // set mailer to use SMTP//		$this->SMTPAuth = true; // turn on SMTP authentication true/false//		$this->Username = user; // SMTP username//		$this->Password = password; // SMTP password//		$this-> = server; // specify smtp server		
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