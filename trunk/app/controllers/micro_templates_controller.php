<?php
class MicroTemplatesController extends AppController {
	var $name = 'MicroTemplates';
	
	function admin_create_from_tag ()
	{
		$this->set('current_crumb',__('Enter an alias to use',true));
		$this->render(null,'admin');		
	}
	
		
	function admin_delete ($id)
	{
		$this->MicroTemplate->del($id);
		$this->Session->setFlash( __('Record deleted.',true));
		$this->redirect('/micro_templates/admin');
	}
	
	function admin_edit ($id = null)
	{
		$this->set('current_crumb', __('Micro Template', true));
		if(empty($this->data))
		{
			$this->data = $this->MicroTemplate->read(null,$id);
			
			$this->render('','admin');
		}
		else
		{
			// Check if we pressed the cancel button
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/micro_templates/admin/');
				die();
			}
			
			// Generate the alias to be safe
			$this->data['MicroTemplate']['alias'] = $this->generateAlias($this->data['MicroTemplate']['alias']);	
		
			$this->MicroTemplate->save($this->data);

			$this->Session->setFlash( __('Micro Template Saved.',true));
			
			if(isset($this->params['form']['apply']))
			{
				if($id == null)
					$id = $this->MicroTemplate->getLastInsertId();
				$this->redirect('/micro_templates/admin_edit/' . $id);
			}
			else
			{
				$this->redirect('/micro_templates/admin');
			}
		}
	}
	
	function admin_new ()
	{
		$this->redirect('/micro_templates/admin_edit/');	
	}
	
	function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Micro Templates Listing', true));
		$this->set('micro_templates',$this->MicroTemplate->findAll());

		if($ajax == true)
			$this->render('','ajax');
		else
			$this->render('','admin');
	}
}
?>