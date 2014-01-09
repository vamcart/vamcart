<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class EventBaseComponent extends Object 
{

	public function beforeFilter ()
	{
	}

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

	public function ProcessEvent ($event_alias)
	{
		App::import('Model', 'Event');
		$Event =& new Event();
		
		$events = $Event->EventHandler->find('all', array('conditions' => array('Event.alias' => $event_alias)));
		
		if(!empty($events))
		{
			foreach($events AS $event)
			{
				$this->requestAction($event['EventHandler']['action'],array('return'));
			}
		}
	
	}
	

	
	
}
?>