<?php
class UserTagsController extends AppController {
   var $name = 'UserTags';
   
	function admin_delete ($UserTag_id)
	{
		$this->UserTag->del($UserTag_id);	
		$this->Session->setFlash(__('Record deleted.', true));		
		$this->redirect('/user_tags/admin/');
	}
	
	function admin_edit ($user_tag_id = null)
	{
		// Check if we pressed the cancel button
		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/user_tags/admin/');die();
		}
	
		if(empty($this->data))	
		{			
			$this->UserTag->id = $user_tag_id;
			$data = $this->UserTag->read();
			
			$this->data = $data;
			$this->set('data',$data);
			$this->render('','admin');
		}
		else
		{
			
			// Generate the alias based depending on whether or not we entered one.
			if($this->data['UserTag']['alias'] == "")
				$this->data['UserTag']['alias'] = $this->generateAlias($this->data['UserTag']['name']);
			else
				$this->data['UserTag']['alias'] = $this->generateAlias($this->data['UserTag']['alias']);	
			
			// Save the user tag
			$this->UserTag->save($this->data);		

			// Check the user defined tag for errors
			srand();
			ob_start();
			if (eval('function testfunction'.rand().'() {'.$this->data['UserTag']['content'].'}') === FALSE)
			{
				$error = array();
                $buffer = ob_get_clean();
				
				$error = __('Invalid Tag Code',true) . ':<br />' . $buffer;
				$this->Session->setFlash($error);

				if($user_tag_id == null)
					$user_tag_id = $this->UserTag->getLastInsertId();	
				$this->redirect('/user_tags/admin_edit/' . $user_tag_id);
				die();
			}
			else
			{
				ob_end_clean();
			}
			
			// Set the flash whether a new user tag or not
			if($user_tag_id == null)
			{
				$this->Session->setFlash(__('User tag created.', true));		
				$user_tag_id = $this->UserTag->getLastInsertId();					
			}
			else
			{
				$this->Session->setFlash(__('User tag updated.', true));
			}
		
		
			if(isset($this->params['form']['apply']))
			{
				$this->redirect('/user_tags/admin_edit/' . $user_tag_id);
			}
			else
			{
				$this->redirect('/user_tags/admin/');
			}
		}
	}	
	
	function admin_new ()
	{
		$this->redirect('/user_tags/admin_edit/');
	}   

	function admin_modify_selected() 
	{
		$build_flash = "";
		foreach($this->params['data']['UserTag']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
			
				// Get the GCB from the database
				$this->UserTag->id = $value;
				$gcb = $this->UserTag->read();
			
				switch ($this->params['form']['multiaction']) 
				{
					case "delete":
					    $this->UserTag->del($value);
						$build_flash .= __('User tag deleted.', true) . ': ' . $gcb['UserTag']['name'] . '<br />';		
					    break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/user_tags/admin/');
	}
   
   function admin ()
	{
		$this->set('user_tags', $this->UserTag->findAll());
		$this->render('','admin');
	}
	
}
?>