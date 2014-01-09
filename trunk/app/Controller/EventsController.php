<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class EventsController extends AppController {
	public $name = 'Events';
   
   
   	public function admin_view($id)
	{
		$this->set('current_crumb', __('Event Details', true));
		$this->set('title_for_layout', __('Event Details', true));
		$event = $this->Event->read(null,$id);
		$this->set('current_crumb_info',$event['Event']['alias']);		
			
		$this->set('event',$event);
		$this->set('event_handlers',$this->Event->EventHandler->find('all', array('conditions' => array('EventHandler.event_id' => $id))));
		
	}
   
	public function admin()
	{
		$this->set('current_crumb', __('Events Listing', true));
		$this->set('title_for_layout', __('Events Listing', true));
		$this->set('event_data',$this->Event->find('all', array('order' => array('Event.alias ASC'))));
	}
}
?>