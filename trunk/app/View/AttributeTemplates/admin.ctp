<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-tag-blue-add');

echo $this->Form->create('AttributeTemplate', array('action' => '/admin_edit/new/'));

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Title'), __('Action')));

foreach ($templates AS $template)
{
    echo $this->Admin->TableCells(array($template['AttributeTemplate']['name']
                                       ,array($this->Admin->ActionButton('edit','/attribute_templates/admin_edit/edit/' . $template['AttributeTemplate']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/attribute_templates/admin_edit/delete/' . $template['AttributeTemplate']['id'],__('Delete')), array('align'=>'center'))
                                  ));
}
echo '</table>';

echo $this->Admin->formButton(__('Create New'), 'cus-add', array('class' => 'btn', 'type' => 'submit', 'name' => 'applybutton'));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();

?>