<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
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