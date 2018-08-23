<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class SearchLogController extends AppController {
	public $name = 'SearchLog';
        public $paginate = array('limit' => 20, 'order' => array('SearchLog.id' => 'asc'));
        
        public function admin ()
			{
            $this->set('current_crumb', __('Search Log Listing', true));
            $this->set('title_for_layout', __('Search Log Listing', true));
            
            $data = $this->paginate('SearchLog');
            $this->set('data',$data);
        	}          
        
			public function admin_delete ($group_id = null)
			{
            $this->SearchLog->delete($group_id);
            $this->Session->setFlash( __('Record deleted.', true));
            $this->redirect('/search_log/admin/');
			}
			
			public function admin_modify_selected() 	
			{
			$build_flash = "";
			foreach($this->params['data']['SearchLog']['modify'] AS $value)
			{
				// Make sure the id is valid
				if($value > 0)
				{
					$this->SearchLog->id = $value;
					$currency = $this->SearchLog->read();
			
					switch ($this->data['multiaction']) 
					{
						case "delete":
							    $this->SearchLog->delete($value);
								$build_flash .= __('Record deleted.', true) . '<br />';									
						break;
					}
				}
			}
			$this->Session->setFlash($build_flash);
			$this->redirect('/search_log/admin/');
			}
							
	}