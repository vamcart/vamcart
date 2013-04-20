<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class UsersController extends AppController {
	public $name = 'Users';
	public $uses = array('User', 'UserPref', 'Language');
	public $components = array('Locale');
	
	public function admin_delete ($user_id)
	{
		if($user_id == $this->Session->read('User.id'))
		{
			$this->Session->setFlash(__('Could not delete that account.', true));
		}
		else	
		{
			$this->User->delete($user_id);
			$this->Session->setFlash(__('Record deleted.', true));
		}
		$this->redirect('/users/admin/');
	}
	
	public function admin_user_account () 
	{
		$this->set('current_crumb', __('My Account Details', true));
		$this->set('title_for_layout', __('My Account Details', true));
		if(!empty($this->data))
		{
			// Redirect if the user pressed cancel
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/admin/admin_top/6/');
			}
			
			// Check if we set a new password, and if so make sure they match.
			if($this->data['User']['password'] != "")
			{
				if($this->data['User']['password'] != $this->data['User']['confirm_password'])
				{
					$this->Session->setFlash(__('Sorry, passwords did not match.', true));
					$this->redirect('/users/admin_user_account/');
					die();
				}
				
				$this->request->data['User']['password'] = Security::hash($this->data['User']['password'], 'sha1', true);

			}
				$this->User->save($this->data);
				
				$this->Session->setFlash(__('Your account settings have been updated.', true));
				$this->redirect('/admin/admin_top/8/');
	
		}
		else
		{
			$this->request->data = $this->User->find('first', array('conditions' => array('id' => $this->Session->read('User.id'))));
				
		}
	}
	
	public function admin_user_preferences () 
	{
		$this->set('current_crumb', __('My Prefences', true));
		$this->set('title_for_layout', __('My Prefences', true));
		if(!empty($this->data))
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/admin/admin_top/8');
				die();
			}
			
			//pr($this->data);
			$this->Session->write('Config.language', $this->data['UserPref']['language']); 
			$this->Session->write('UserPref.language', $this->data['UserPref']['language']); 			
			$user_prefs = $this->User->UserPref->find('first', array('conditions' => array('user_id' => $_SESSION['User']['id'], 'name' => 'language')));
			$user_prefs['UserPref']['language'] = $this->data['UserPref']['language'];
			$this->User->UserPref->save($user_prefs);
			$this->Session->setFlash(__('Record saved.', true));
			
			$this->redirect('/users/admin_user_preferences/');
			die();
		}		

		$languages = $this->Language->find('all', array('order' => array('Language.id ASC')));
		$languages_list = array();
		
		foreach($languages AS $language)
		{
			$language_key = $language['Language']['iso_code_2'];
			$languages_list[$language_key] = $language['Language']['name'];
		}
		
		$this->set('available_languages', $languages_list);	
		$this->set('current_language', $this->Session->read('UserPref.language'));	

	}


	   
	public function admin_logout ()
	{
		$this->layout = 'default';
	
		$this->Session->delete('User');
		$this->Session->setFlash(__('You have logged out.', true));
		$this->redirect('/users/admin_login');
	
	}

	public function admin_login ()
	{
	
		$this->layout = 'default';
		$this->set('current_crumb', __('Login', true));
		$this->set('title_for_layout', __('Login', true));
		if(empty($this->data))
		{
			// Redirect the user if we're logged in
			if($this->Session->check('User.username'))
				$this->redirect('/admin/admin_top/');
		}
		else
		{
			$admin_user = $this->User->find('first', array('conditions' => array('username' => $this->data['User']['username'],'password' => Security::hash($this->data['User']['password'], 'sha1', true))));

			if(empty($admin_user))
			{
				// If there was an error set the flash and render
				$this->Session->setFlash(__('No match for Username and/or Password.', true));
			}

			if(!empty($admin_user))
			{
			// Write to the session and redirect
			$this->Session->write('User', $admin_user['User']);
			$this->Session->write('UserPref', $this->UserPref->find('list', array('user_id' => $admin_user['User']['id']), null, null, '{n}.UserPref.name', '{n}.UserPref.value'));
			$this->redirect('/admin/admin_top/');
			}		
		}
	}	
	
	public function admin_new ()
	{	
		$this->set('current_crumb', __('New Admin', true));
		$this->set('title_for_layout', __('New Admin', true));
		if(empty($this->data))
		{
		}
		else
		{
			// Redirect if the user pressed cancel
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/users/admin/');
				die();
			}
			
			// Check for other users with this username
			$check_username = $this->User->find('count', array('conditions' => array('username' => $this->data['User']['username'])));
			
			if($check_username > 0)
			{
				$this->Session->setFlash( __('Could not create user account. User exists.', true));
				$this->redirect('/users/admin/');
				die();
			}

			
			$this->request->data['User']['password'] = Security::hash($this->data['User']['password'], 'sha1', true);
			$this->User->save($this->data);
			
			// Set some default preferences
			$user_id = $this->User->getLastInsertId();
			
			$new_prefs = array('content_collapse','template_collpase','language');
			foreach($new_prefs AS $key => $value)
			{
				//pr($pref);
				$this->UserPref->create();
				
				$pref = array();
				$pref['UserPref']['user_id'] = $user_id;
				$pref['UserPref']['name'] = $value;
				
				$this->UserPref->save($pref);
			
			}
			
			$this->Session->setFlash( __('Record created.', true));
			$this->redirect('/users/admin/');
		}
	}
	
	public function admin () 
	{
		$this->set('current_crumb', __('Admins Listing', true));
		$this->set('title_for_layout', __('Admins Listing', true));
		$this->set('users', $this->User->find('all'));
	}	
}
?>