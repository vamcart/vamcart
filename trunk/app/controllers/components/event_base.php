<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class EventBaseComponent extends Object 
{

	function beforeFilter ()
	{
		
	}

    function startup(&$controller)
	{

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