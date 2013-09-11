<?php
class AttributeTemplatesController extends AppController {
    public $name = 'AttributeTemplates';
	
    public function admin_edit ($action = 'init' ,$id = null)
    {
        switch ($action) 
	{
            case 'init':
                
            break;
            case 'edit':
                $this->request->data = $this->AttributeTemplate->read(null,$id);
            break;
            case 'new':
                $this->request->data = array('AttributeTemplate' => array('id' => 0));
            break;
            case 'save':
                if(isset($this->data['cancelbutton']))$this->redirect('/attributetemplates/admin');
                if(!empty($this->data))
                    if($this->AttributeTemplate->save($this->data['AttributeTemplate']))
                    {
                        $this->Session->setFlash('Record saved.');
                    } else $this->Session->setFlash('Record not saved!', 'default', array('class' => 'error-message red'));  
                if(isset($this->data['apply'])) 
                {
                    if($id == null) $id = $this->AttributeTemplate->getLastInsertId();
                    $this->redirect('/attributetemplates/admin_edit/edit/' . $id);
                }
                else $this->redirect('/attributetemplates/admin');
            break;
            case 'delete':
                $this->AttributeTemplate->delete($id);	
                $this->Session->setFlash(__('Record deleted.', true));		
                $this->redirect('/attributetemplates/admin/');
            break;
            default:
                die();
            break;
        }
        
    	$this->set('current_crumb', __('Template', true));
	$this->set('title_for_layout', __('Template', true));
                 
    }	
	
    public function admin_new ()
    {
    	$this->redirect('/attributetemplates/admin_edit/');
    }   
   
    public function admin ()
    {
		$this->set('current_crumb', __('Templates Listing', true));
		$this->set('title_for_layout', __('Templates Listing', true));
		$this->set('templates', $this->AttributeTemplate->find('all'));
    }
	
}
?>