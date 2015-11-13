<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<div class="modal fade" id="editAttrModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-primary" id="feature-title"><?php echo __('Add/Edit');?></h4>
      </div>
      <div class="modal-body clearfix">
      
        <?php
            echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
            echo $this->Form->create('Attribute', array('id' => 'attributeform', 'name' => 'attributeform','enctype' => 'multipart/form-data', 'action' => '/admin_editor_attr/save/' . $type));

            echo $this->Form->input('id',array('type' => 'hidden',
                                                       'value' => $attribute['Attribute']['id']
                                   ));
            echo $this->Form->input('parent_id',array('type' => 'hidden',
                                                       'value' => $attribute['Attribute']['parent_id']
                                   ));
            echo $this->Form->input('content_id',array('type' => 'hidden',
                                                       'value' => $attribute['Attribute']['content_id']
                                   ));
            echo $this->Form->input('order',array('type' => 'hidden',
                                                       'value' => $attribute['Attribute']['order']
                                   ));


            echo '<ul id="myTabLang" class="nav nav-tabs">';
            $i = 0;
            foreach($languages AS $language)
            {
                echo $this->Admin->CreateTab('language_attr_'.$language['Language']['id'],$language['Language']['name'],'cus-page-white',($i == 0 ? 'active' : null));
            $i++;
            }
            echo '</ul>';
            echo $this->Admin->StartTabs('sub-tabs');

            foreach($languages AS $language)
            {
                $language_key = $language['Language']['id'];
                echo $this->Admin->StartTabContent('language_attr_'.$language_key);
                echo $this->Form->input('AttributeDescription][' . $language['Language']['id'] . '][dsc_id',array('type' => 'hidden',
                                                       'value' => isset($attribute['AttributeDescription'][$language_key]['dsc_id']) ? $attribute['AttributeDescription'][$language_key]['dsc_id'] : 0
                                   ));
                echo $this->Form->input('AttributeDescription][' . $language['Language']['id'] . '][name', 
                                            array(
                                            'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Name'),
                                            'type' => 'text',
                                            'value' => isset($attribute['AttributeDescription'][$language_key]['name']) ? $attribute['AttributeDescription'][$language_key]['name'] : ''
                                            ));
                echo $this->Admin->EndTabContent();
            }
            echo '</div>';//$this->Admin->EndTabs();

            if($type != 'attr')   
            {
                echo $this->Form->input('Attribute.type_attr',array(
                                            'type' => 'select',
                                            'label' => __('Value Type'),
                                            'options' => $template,//array('list_value' => 'list value','max' => 'max value','min' => 'min value','value' => 'numeric value','like' => 'mask value'),
                                            'selected' => isset($attribute['Attribute']['type_attr']) ? $attribute['Attribute']['type_attr'] : ''
                                    ));
                echo $this->Form->input('Attribute.val',array(
                                            'type' => 'text',
                                            'label' => __('Default value'),
                                            'value' => isset($attribute['Attribute']['val']) ? $attribute['Attribute']['val'] : ''
                                    ));
                echo $this->Form->input('Attribute.price_modificator',array(
                                            'type' => 'select',
                                            'label' => __('Price Modificator'),
                                            'options' => array('0' => __('no'),'=' => '=','+' => '+','-' => '-','/' => '/','*' => '*'),
                                            'selected' => isset($attribute['Attribute']['price_modificator']) ? $attribute['Attribute']['price_modificator'] : ''
                                    ));
                echo $this->Form->input('Attribute.price_value',array(
                                            'type' => 'text',
                                            'label' => __('Modificator Value'),
                                            'value' => isset($attribute['Attribute']['price_value']) ? $attribute['Attribute']['price_value'] : '0'
                                    ));
            }
            else if($type == 'attr')
            {

                echo $this->Form->input('Attribute.price_value',array(
                                            'type' => 'hidden',
                                            'value' => '0'
                                    ));

                echo $this->Form->input('Attribute.attribute_template_id',array(
                                            'type' => 'select',
                                            'label' => __('Attribute Type'),
                                            'options' => $template,
                                            'selected' => isset($attribute['Attribute']['attribute_template_id']) ? $attribute['Attribute']['attribute_template_id'] : '',
                                            'after' => ' '.$this->Html->link($this->Html->image("admin/icons/new.png", array('alt' => __('Attribute Templates'), 'title' => __('Attribute Templates'))),'/attribute_templates/admin/', array('escape' => false, 'target' => '_blank'))
                                    ));

            }
            
            echo $this->Js->link('<i class="cus-disk"></i> ' . __('Apply'), '/attributes/admin_editor_attr/save/' . $type,
                array(
                    'class' => 'btn btn-default'
                   ,'escape' => false
                   ,'update' => '#view_attr'
                   ,'method' => 'post'
                   ,'data' => $this->Js->get('#attributeform')->serializeForm(array('isForm' => true,'inline' => true))
                   ,'dataExpression' => true
                   ,'success' => '$("#editAttrModal").modal("hide");'
                )
            );
            
            echo $this->Js->writeBuffer();            

            echo $this->Form->end();
            echo $this->Admin->ShowPageHeaderEnd();
            ?>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
<?php 
    echo $this->Html->scriptBlock('$("#editAttrModal").modal("show").on("shown.bs.modal", function (){});');
?>

<script type="text/javascript">
    $(document).ready(function() {
  
        });    
</script>