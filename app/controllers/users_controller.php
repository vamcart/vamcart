<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class UsersController extends AppController {
	var $name = 'Users';
	var $uses = array('User', 'UserPref', 'Language');
	var $helpers = array('Html','Javascript','Admin','Form');
	var $components = array('Locale');
	
	function admin_delete ($user_id)
	{
		if($user_id == $this->Session->read('User.id'))
		{
			$this->Session->setFlash(__('Could not delete that account.', true));
		}
		else	
		{
			$this->User->del($user_id);
			$this->Session->setFlash(__('Record deleted.', true));
		}
		$this->redirect('/users/admin/');
	}
	
	function admin_user_account () 
	{
		$this->set('current_crumb', __('My Account Details', true));
		if(!empty($this->data))
		{
			// Redirect if the user pressed cancel
			if(isset($this->params['form']['cancel']))
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
				
				$this->data['User']['password'] = md5($this->data['User']['password']);

			}
				$this->User->save($this->data);
				
				$this->Session->setFlash(__('Your account settings have been updated.', true));
				$this->redirect('/admin/admin_top/8/');
	
		}
		else
		{
			$this->data = $this->User->find(array('id' => $this->Session->read('User.id')));
				
			$this->render('','admin');
		}
	}
	
	function admin_user_preferences () 
	{
		$this->set('current_crumb', __('My Prefences', true));
		if(!empty($this->data))
		{
			if(isset($this->params['form']['cancelbutton']))
			{
				$this->redirect('/admin/admin_top/8');
				die();
			}
			
			//pr($this->data);
			$this->Session->write('Config.language', $this->data['UserPref']['language']); 
			$this->Session->write('UserPref.language', $this->data['UserPref']['language']); 			
			$user_prefs = $this->User->UserPref->find(array('user_id' => $_SESSION['User']['id'], 'name' => 'language'));
			$user_prefs['UserPref']['language'] = $this->data['UserPref']['language'];
			$this->User->UserPref->save($user_prefs);
			$this->Session->setFlash(__('Record saved.', true));
			
			$this->redirect('/users/admin_user_preferences/');
			die();
		}		

		$languages = $this->Language->findAll(null,null,'Language.id ASC');
		$languages_list = array();
		
		foreach($languages AS $language)
		{
			$language_key = $language['Language']['iso_code_2'];
			$languages_list[$language_key] = $language['Language']['name'];
		}
		
		$this->set('available_languages', $languages_list);	

		$this->render('','admin');

	}


	   
	function admin_logout ()
	{
	
		$this->Session->del('User');
		$this->Session->setFlash(__('You have logged out.', true));
		$this->redirect('/users/admin_login');
	
	}

	function admin_login ()
	{
		if(empty($this->data))
		{
			// Redirect the user if we're logged in
			if($this->Session->check('User.username'))
				$this->redirect('/admin/admin_top/');
		}
		else
		{
			$admin_user = $this->User->find(array('username' => $this->data['User']['username'],'password' => md5($this->data['User']['password'])));

			if(empty($admin_user))
			{
				// If there was an error set the flash and render
				$this->Session->setFlash(__('No match for Username and/or Password.', true));
			}
			// Write to the session and redirect
			$this->Session->write('User', $admin_user['User']);
			$this->Session->write('UserPref', $this->UserPref->find('list', array('user_id' => $admin_user['User']['id']), null, null, '{n}.UserPref.name', '{n}.UserPref.value'));
			$this->redirect('/admin/admin_top/');		
		}
	}	
	
	function admin_new ()
	{	
		$this->set('current_crumb', __('New Admin', true));
		if(empty($this->data))
		{
			$this->render('','admin');
		}
		else
		{
			// Redirect if the user pressed cancel
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/users/admin/');
				die();
			}
			
			// Check for other users with this username
			$check_username = $this->User->findCount(array('username' => $this->data['User']['username']));
			
			if($check_username > 0)
			{
				$this->Session->setFlash( __('Could not create user account. User exists.', true));
				$this->redirect('/users/admin/');
				die();
			}

			
			$this->data['User']['password'] = md5($this->data['User']['password']);
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
	
	function admin () 
	{
		$this->set('current_crumb', __('Admins Listing', true));
		$this->set('users', $this->User->findAll());
		$this->render('','admin');
	}	
}
?>