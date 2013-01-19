<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class EventBaseComponent extends Object 
{

	function beforeFilter ()
	{
		
	}

    public function initialize(Controller $controller) {
	}
    
public function startup(Controller $controller) {
	}

public function shutdown(Controller $controller) {
	}
    
public function  beforeRender(Controller $controller){
	}

	function ProcessEvent ($event_alias)
	{
		App::import('Model', 'Event');
		$this->Event =& new Event();
		
		$events = $this->Event->EventHandler->find('all', array('conditions' => array('Event.alias' => $event_alias)));
		
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