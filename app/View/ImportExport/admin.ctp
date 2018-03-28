<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$l = $this->Session->read('Config.language');

if (NULL == $l) {
	$l = $this->Session->read('Customer.language');
}

$l = substr($l, 0, 2);

$fname = 'datepicker-' . $l . '.js';

if (!file_exists(WWW_ROOT . 'js/jquery/plugins/jquery-ui/' . $fname)) {
	$fname = 'datepicker-en.js';
}

$this->Html->script(array(
	'jquery/plugins/switch/bootstrap-switch.js',
	'jquery/plugins/chosen/chosen.jquery.js',
	'jquery/plugins/ui/jquery-ui.min.js',
	'jquery/plugins/jquery-ui/' . $fname,
	'admin/selectall.js'
), array('inline' => false));

$this->Html->css(array(
	'jquery/plugins/switch/bootstrap-switch.css',
	'jquery/plugins/chosen/bootstrap-chosen.css',
	'jquery/plugins/ui/jquery-ui.css'
	), null, array('inline' => false));
?>
<style type="text/css">
.ui-sortable tr {
	cursor:pointer;
}
		
.ui-sortable tr:hover {
	background: #fcf8e3;
}

</style>
<?php echo $this->Html->scriptBlock('
    $(document).ready(function() {

		$(function() {
			$( "#date_start" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
			$( "#date_end" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		});

      $(function() {
        $(".chosen-select").chosen({width: "200px"});
      });
      
      $(function() {
      $("input[type=\"checkbox\"], input[type=\"radio\"]").not("[data-switch-no-init]").bootstrapSwitch();
      });


    $("[data-switch-toggle]").on("click", function() {
      var type;
      type = $(this).data("switch-toggle");
      return $(".export-" + type).bootstrapSwitch("toggle" + type.charAt(0).toUpperCase() + type.slice(1));
    });

    });
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php echo $this->Html->scriptBlock('
$(document).ready(function() {
	//Helper function to keep table row from collapsing when being sorted
	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index)
		{
		  $(this).width($originals.eq(index).width())
		});
		return $helper;
	};

	//Make diagnosis table sortable
	$(".sortable_list tbody").sortable({
    	helper: fixHelperModified,
		//stop: function(event,ui) {renumber_table(".sortable_list")}
	}).disableSelection();

});

//Renumber table rows
function renumber_table(tableID) {
	$(tableID + " tr").each(function() {
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find(".priority").html(count);
	});
}
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>

<?php echo $this->Html->scriptBlock('

$(document).ready(function () {

$("#myTab a:first").tab("show"); // Select first tab	
$("#myTabProducts a:first").tab("show"); // Select first tab	
$("#myAttrProducts a:first").tab("show"); //
//$("#myImgProducts a:first").tab("show"); //
$("#myTabManufacturers a:first").tab("show"); // Select first tab	
$("#myTabCategories a:first").tab("show"); // Select first tab	
$("#myTabPages a:first").tab("show"); // Select first tab	
$("#myTabArticles a:first").tab("show"); // Select first tab	
$("#myTabNews a:first").tab("show"); // Select first tab	
$("#myTabCustomers a:first").tab("show"); // Select first tab	
$("#myTabOrders a:first").tab("show"); // Select first tab
});
	
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>


<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-database-refresh');

echo '<ul id="myTab" class="nav nav-tabs">';
echo $this->Admin->CreateTab('products',__('Products',true), 'cus-table');
echo $this->Admin->CreateTab('attr',__('Attributes',true), 'cus-table');
//echo $this->Admin->CreateTab('img',__('Images',true), 'cus-table');
echo $this->Admin->CreateTab('manufacturers',__('Brands',true), 'cus-tag-blue');
echo $this->Admin->CreateTab('categories',__('Categories',true), 'cus-report');
echo $this->Admin->CreateTab('pages',__('Pages',true), 'cus-page');
echo $this->Admin->CreateTab('articles',__('Articles',true), 'cus-book-add');
echo $this->Admin->CreateTab('news',__('News',true), 'cus-newspaper');
echo $this->Admin->CreateTab('customers',__('Customers',true), 'cus-user');
echo $this->Admin->CreateTab('orders',__('Orders',true), 'cus-cart');
echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('products');

echo '<!-- Products Tab Start -->';

echo '<ul id="myTabProducts" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-products',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-products',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('products');

echo $this->Admin->StartTabContent('export-products');

    echo $this->Form->create('ImportExport', array('id' => 'products_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/products'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' . __('Required Fields: alias, model, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>        
        <tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.model','readonly' => true,'order' => 1)) . '</td><td>model</td><td>' . __('Product Model. <span class="text-danger">Product Model must be unique for every product.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.name','readonly' => true,'order' => 2)) . '</td><td>name</td><td>' . __('Product Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.parents','readonly' => true,'order' => 3)) . '</td><td>parent</td><td>' . __('Product Category.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.alias','readonly' => true,'order' => 4)) . '</td><td>alias</td><td>' . __('Product alias. Alias must be unique for every product. <span class="text-danger">Alias used for url generation of product. For example, if you set: iphone, url for this product will be: http://your-store.com/product/iphone.html.</span>') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.sku','order' => 5)) . '</td><td>sku</td><td>' . __('SKU.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.stock','order' => 6)) . '</td><td>stock</td><td>' . __('Stock.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.price','order' => 7)) . '</td><td>price</td><td>' . __('Product Price.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.weight','order' => 8)) . '</td><td>weight</td><td>' . __('Weight.') . '</span></td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.label','order' => 9)) . '</td><td>label</td><td>' . __('Product Label.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.manufacturer','order' => 10)) . '</td><td>manufacturer</td><td>' . __('Brand.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.description','order' => 11)) . '</td><td>description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.short_description','order' => 12)) . '</td><td>short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_title','order' => 13)) . '</td><td>meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_description','order' => 14)) . '</td><td>meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_keywords','order' => 15)) . '</td><td>meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.image','order' => 16)) . '</td><td>image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.order','order' => 17)) . '</td><td>order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.active','order' => 18)) . '</td><td>active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.show_in_menu','order' => 19)) . '</td><td>show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.yml_export','order' => 20)) . '</td><td>yml_export</td><td>' . __('YML Export. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.viewed','order' => 21)) . '</td><td>viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.created','order' => 22)) . '</td><td>created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.modified','order' => 23)) . '</td><td>modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.action','order' => 24)) . '</td><td>action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.tax_id','order' => 25)) . '</td><td>tax_id</td><td>' . __('Tax Id.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.template_id','order' => 26)) . '</td><td>template_id</td><td>' . __('Template Id.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.is_group','order' => 27)) . '</td><td>is_group</td><td>' . __('Grouped Product.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.id_group','order' => 28)) . '</td><td>id_group</td><td>' . __('Group.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            

		echo $this->Form->input('ImportExport.parent_id', 
					array(
						'type' => 'select',
						'id' => 'selected_content',
						'data-placeholder' => __('All Categories'),
						'class' => 'chosen-select',
						'multiple' => true,
			   		'label' => __('Categories'),
						'options' => $this->requestAction('/contents/admin_parents_tree/'),
						'escape' => false,
						//'empty' => array(0 => __('Все категории'))
               ));

	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-products');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/products'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' . __('Required Fields: alias, model, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Content.ContentProduct.model',array('type' => 'hidden')) . 'model</td><td>' . __('Product Model. <span class="text-danger">Product Model must be unique for every product.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Content.ContentDescription.name',array('type' => 'hidden')) . 'name</td><td>' . __('Product Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.3.Content.parent',array('type' => 'hidden')) . 'parent</td><td>' . __('Product Category.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.4.Content.alias',array('type' => 'hidden')) . 'alias</td><td>' . __('Product alias. Alias must be unique for every product. <span class="text-danger">Alias used for url generation of product. For example, if you set: iphone, url for this product will be: http://your-store.com/product/iphone.html.</span>') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.5.Content.ContentProduct.sku',array('type' => 'hidden')) . 'sku</td><td>' . __('SKU.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.6.Content.ContentProduct.stock',array('type' => 'hidden')) . 'stock</td><td>' . __('Stock.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.7.Content.ContentProduct.price',array('type' => 'hidden')) . 'price</td><td>' . __('Product Price.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Content.ContentProduct.weight',array('type' => 'hidden')) . 'weight</td><td>' . __('Weight.') . '</span></td></tr>
	<tr><td>' . $this->Form->input('Fields.9.Content.ContentProduct.label',array('type' => 'hidden')) . 'label</td><td>' . __('Product Label.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.10.Content.ContentProduct.manufacturer',array('type' => 'hidden')) . 'manufacturer</td><td>' . __('Brand.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.11.Content.ContentDescription.description',array('type' => 'hidden')) . 'description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.12.Content.ContentDescription.short_description',array('type' => 'hidden')) . 'short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.13.Content.ContentDescription.meta_title',array('type' => 'hidden')) . 'meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.14.Content.ContentDescription.meta_description',array('type' => 'hidden')) . 'meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.15.Content.ContentDescription.meta_keywords',array('type' => 'hidden')) . 'meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.16.Content.image',array('type' => 'hidden')) . 'image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.17.Content.order',array('type' => 'hidden')) . 'order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.18.Content.active',array('type' => 'hidden')) . 'active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.19.Content.show_in_menu',array('type' => 'hidden')) . 'show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.20.Content.yml_export',array('type' => 'hidden')) . 'yml_export</td><td>' . __('YML Export. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.21.Content.viewed',array('type' => 'hidden')) . 'viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.22.Content.created',array('type' => 'hidden')) . 'created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.23.Content.modified',array('type' => 'hidden')) . 'modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.24.Content.action',array('type' => 'hidden')) . 'action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.25.Content.ContentProduct.tax_id',array('type' => 'hidden')) . 'tax_id</td><td>' . __('Tax Id.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.26.Content.template_id',array('type' => 'hidden')) . 'template_id</td><td>' . __('Template Id.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.27.Content.is_group',array('type' => 'hidden')) . 'is_group</td><td>' . __('Grouped Product.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.28.Content.id_group',array('type' => 'hidden')) . 'id_group</td><td>' . __('Group.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo '<!-- /Products Tab End -->';

echo $this->Admin->EndTabContent();


echo $this->Admin->StartTabContent('attr');
echo '<ul id="myAttrProducts" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-attr',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-attr',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('attr');

echo $this->Admin->StartTabContent('export-attr');

    echo $this->Form->create('ImportExport', array('id' => 'attr_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/attr'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' . __('') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>        
        <tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentProduct.model','readonly' => true,'order' => 1)) . '</td><td>model</td><td>' . __('Product Model.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.name','readonly' => true,'order' => 2)) . '</td><td>name</td><td>' . __('Attribute Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.value','readonly' => true,'order' => 3)) . '</td><td>value</td><td>' . __('Attribute Value.') . '</td></tr>
        <tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AttributeTemplate.name','readonly' => true,'order' => 4)) . '</td><td>template</td><td>' . __('Attribute Template.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.type_attr','readonly' => true,'order' => 5)) . '</td><td>type_attr</td><td>' . __('Attribute Type.') . '</td></tr>
        <tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.order','order' => 6)) . '</td><td>order</td><td>' . __('Sort Order.') . '</span></td></tr>            
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.price_modificator','order' => 7)) . '</td><td>price_modificator</td><td>' . __('Price Modificator.') . '</span></td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.price_value','order' => 8)) . '</td><td>price_value</td><td>' . __('Price Modificator Value.') . '</td></tr>
        <tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.is_active','order' => 9)) . '</td><td>is_active</td><td>' . __('Active State.') . '</td></tr>
        <tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.is_show_flt','order' => 10)) . '</td><td>is_show_flt</td><td>' . __('Show Filter.') . '</td></tr>    
            <tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Attribute.is_show_cmp','order' => 11)) . '</td><td>is_show_cmp</td><td>' . __('Show Comparison.') . '</td></tr>    
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            

		echo $this->Form->input('ImportExport.category_id', 
					array(
						'type' => 'select',
						'data-placeholder' => __('All Categories'),
						'class' => 'chosen-select',
						'multiple' => true,
			   		'label' => __('Categories'),
						'options' => $this->requestAction('/contents/admin_parents_tree/'),
						'escape' => false,
						//'empty' => array(0 => __('Все категории'))
               ));

	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-attr');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/attr'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' . __('') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Content.ContentProduct.model',array('type' => 'hidden')) . 'model</td><td>' . __('Product Model.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Content.Attribute.name',array('type' => 'hidden')) . 'name</td><td>' . __('Attribute Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.3.Content.Attribute.value',array('type' => 'hidden')) . 'value</td><td>' . __('Attribute Value.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.4.Content.AttributeTemplate.name',array('type' => 'hidden')) . 'template</td><td>' . __('Attribute Template.') . '</td></tr>            
	<tr class="warning"><td>' . $this->Form->input('Fields.5.Content.Attribute.type_attr',array('type' => 'hidden')) . 'type_attr</td><td>' . __('Attribute Type.') . '</td></tr>
        <tr class="warning"><td>' . $this->Form->input('Fields.6.Content.Attribute.order',array('type' => 'hidden')) . 'order</td><td>' . __('Sort Order.') . '</td></tr>            
	<tr><td>' . $this->Form->input('Fields.7.Content.Attribute.price_modificator',array('type' => 'hidden')) . 'price_modificator</td><td>' . __('Price Modificator.') . '</span></td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Content.Attribute.price_value',array('type' => 'hidden')) . 'price_value</td><td>' . __('Price Modificator Value.') . '</td></tr>
        <tr><td>' . $this->Form->input('Fields.9.Content.Attribute.is_active',array('type' => 'hidden')) . 'is_active</td><td>' . __('Active State.') . '</td></tr>
        <tr><td>' . $this->Form->input('Fields.10.Content.Attribute.is_show_flt',array('type' => 'hidden')) . 'is_show_flt</td><td>' . __('Show Filter.') . '</td></tr>
        <tr><td>' . $this->Form->input('Fields.11.Content.Attribute.is_show_cmp',array('type' => 'hidden')) . 'is_show_cmp</td><td>' . __('Show Comparison.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));

    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Admin->EndTabContent();


//echo $this->Admin->StartTabContent('img');
//echo '<ul id="myImgProducts" class="nav nav-tabs">';
//echo $this->Admin->CreateTab('import-img',__('Import',true), 'cus-arrow-in');
//echo '</ul>';
//echo $this->Admin->StartTabs('img');

//echo $this->Admin->StartTabContent('export-img');
//echo $this->Admin->EndTabContent();
// echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    //echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/images'));

    //echo $this->Form->file('submittedfile');

    //echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    //echo $this->Form->end();
//echo $this->Admin->EndTabs();
//echo $this->Admin->EndTabContent();


echo $this->Admin->StartTabContent('manufacturers');

echo '<!-- Manufacturers Tab Start -->';

echo '<ul id="myTabManufacturers" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-manufacturers',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-manufacturers',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('manufacturers');

echo $this->Admin->StartTabContent('export-manufacturers');

    echo $this->Form->create('ImportExport', array('id' => 'manufacturers_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/manufacturers'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.alias','readonly' => true,'order' => 1)) . '</td><td>alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.name','readonly' => true,'order' => 2)) . '</td><td>name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.parents','readonly' => true,'order' => 3)) . '</td><td>parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.description','order' => 4)) . '</td><td>description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.short_description','order' => 5)) . '</td><td>short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_title','order' => 6)) . '</td><td>meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_description','order' => 7)) . '</td><td>meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_keywords','order' => 8)) . '</td><td>meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.image','order' => 9)) . '</td><td>image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.order','order' => 10)) . '</td><td>order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.active','order' => 11)) . '</td><td>active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.show_in_menu','order' => 12)) . '</td><td>show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.viewed','order' => 13)) . '</td><td>viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.created','order' => 14)) . '</td><td>created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.modified','order' => 15)) . '</td><td>modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.action','order' => 16)) . '</td><td>action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.template_id','order' => 17)) . '</td><td>template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            

	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-manufacturers');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/manufacturers'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Content.alias',array('type' => 'hidden')) . 'alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Content.ContentDescription.name',array('type' => 'hidden')) . 'name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.3.Content.parent',array('type' => 'hidden')) . 'parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.4.Content.ContentDescription.description',array('type' => 'hidden')) . 'description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.5.Content.ContentDescription.short_description',array('type' => 'hidden')) . 'short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.6.Content.ContentDescription.meta_title',array('type' => 'hidden')) . 'meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.7.Content.ContentDescription.meta_description',array('type' => 'hidden')) . 'meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Content.ContentDescription.meta_keywords',array('type' => 'hidden')) . 'meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.9.Content.image',array('type' => 'hidden')) . 'image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.10.Content.order',array('type' => 'hidden')) . 'order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.11.Content.active',array('type' => 'hidden')) . 'active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.12.Content.show_in_menu',array('type' => 'hidden')) . 'show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.13.Content.viewed',array('type' => 'hidden')) . 'viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.14.Content.created',array('type' => 'hidden')) . 'created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.15.Content.modified',array('type' => 'hidden')) . 'modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.16.Content.action',array('type' => 'hidden')) . 'action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.17.Content.template_id',array('type' => 'hidden')) . 'template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();


echo '<!-- /Manufacturers Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('categories');

echo '<!-- Categories Tab Start -->';


echo '<ul id="myTabCategories" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-categories',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-categories',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('categories');

echo $this->Admin->StartTabContent('export-categories');

    echo $this->Form->create('ImportExport', array('id' => 'categories_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/categories'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.alias','readonly' => true,'order' => 1)) . '</td><td>alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.name','readonly' => true,'order' => 2)) . '</td><td>name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.parents','readonly' => true,'order' => 3)) . '</td><td>parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.description','order' => 4)) . '</td><td>description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.short_description','order' => 5)) . '</td><td>short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_title','order' => 6)) . '</td><td>meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_description','order' => 7)) . '</td><td>meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_keywords','order' => 8)) . '</td><td>meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.image','order' => 9)) . '</td><td>image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.order','order' => 10)) . '</td><td>order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.active','order' => 11)) . '</td><td>active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.show_in_menu','order' => 12)) . '</td><td>show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.viewed','order' => 13)) . '</td><td>viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.created','order' => 14)) . '</td><td>created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.modified','order' => 15)) . '</td><td>modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.action','order' => 16)) . '</td><td>action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.template_id','order' => 17)) . '</td><td>template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            
    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-categories');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/categories'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Content.alias',array('type' => 'hidden')) . 'alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Content.ContentDescription.name',array('type' => 'hidden')) . 'name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.3.Content.parent',array('type' => 'hidden')) . 'parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.4.Content.ContentDescription.description',array('type' => 'hidden')) . 'description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.5.Content.ContentDescription.short_description',array('type' => 'hidden')) . 'short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.6.Content.ContentDescription.meta_title',array('type' => 'hidden')) . 'meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.7.Content.ContentDescription.meta_description',array('type' => 'hidden')) . 'meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Content.ContentDescription.meta_keywords',array('type' => 'hidden')) . 'meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.9.Content.image',array('type' => 'hidden')) . 'image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.10.Content.order',array('type' => 'hidden')) . 'order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.11.Content.active',array('type' => 'hidden')) . 'active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.12.Content.show_in_menu',array('type' => 'hidden')) . 'show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.13.Content.viewed',array('type' => 'hidden')) . 'viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.14.Content.created',array('type' => 'hidden')) . 'created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.15.Content.modified',array('type' => 'hidden')) . 'modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.16.Content.action',array('type' => 'hidden')) . 'action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.17.Content.template_id',array('type' => 'hidden')) . 'template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();


echo '<!-- /Categories Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('pages');

echo '<!-- Pages Tab Start -->';

echo '<ul id="myTabPages" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-pages',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-pages',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('pages');

echo $this->Admin->StartTabContent('export-pages');

    echo $this->Form->create('ImportExport', array('id' => 'pages_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/pages'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.alias','readonly' => true,'order' => 1)) . '</td><td>alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.name','readonly' => true,'order' => 2)) . '</td><td>name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.parents','readonly' => true,'order' => 3)) . '</td><td>parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.description','order' => 4)) . '</td><td>description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.short_description','order' => 5)) . '</td><td>short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_title','order' => 6)) . '</td><td>meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_description','order' => 7)) . '</td><td>meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_keywords','order' => 8)) . '</td><td>meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.image','order' => 9)) . '</td><td>image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.order','order' => 10)) . '</td><td>order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.active','order' => 11)) . '</td><td>active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.show_in_menu','order' => 12)) . '</td><td>show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.viewed','order' => 13)) . '</td><td>viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.created','order' => 14)) . '</td><td>created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.modified','order' => 15)) . '</td><td>modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.action','order' => 16)) . '</td><td>action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.template_id','order' => 17)) . '</td><td>template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            
    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-pages');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/pages'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Content.alias',array('type' => 'hidden')) . 'alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Content.ContentDescription.name',array('type' => 'hidden')) . 'name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.3.Content.parent',array('type' => 'hidden')) . 'parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.4.Content.ContentDescription.description',array('type' => 'hidden')) . 'description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.5.Content.ContentDescription.short_description',array('type' => 'hidden')) . 'short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.6.Content.ContentDescription.meta_title',array('type' => 'hidden')) . 'meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.7.Content.ContentDescription.meta_description',array('type' => 'hidden')) . 'meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Content.ContentDescription.meta_keywords',array('type' => 'hidden')) . 'meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.9.Content.image',array('type' => 'hidden')) . 'image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.10.Content.order',array('type' => 'hidden')) . 'order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.11.Content.active',array('type' => 'hidden')) . 'active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.12.Content.show_in_menu',array('type' => 'hidden')) . 'show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.13.Content.viewed',array('type' => 'hidden')) . 'viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.14.Content.created',array('type' => 'hidden')) . 'created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.15.Content.modified',array('type' => 'hidden')) . 'modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.16.Content.action',array('type' => 'hidden')) . 'action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.17.Content.template_id',array('type' => 'hidden')) . 'template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();


echo '<!-- /Pages Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('articles');

echo '<!-- Articles Tab Start -->';

echo '<ul id="myTabArticles" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-articles',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-articles',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('articles');

echo $this->Admin->StartTabContent('export-articles');

    echo $this->Form->create('ImportExport', array('id' => 'articles_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/articles'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.alias','readonly' => true,'order' => 1)) . '</td><td>alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.name','readonly' => true,'order' => 2)) . '</td><td>name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.parents','readonly' => true,'order' => 3)) . '</td><td>parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.description','order' => 4)) . '</td><td>description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.short_description','order' => 5)) . '</td><td>short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_title','order' => 6)) . '</td><td>meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_description','order' => 7)) . '</td><td>meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_keywords','order' => 8)) . '</td><td>meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.image','order' => 9)) . '</td><td>image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.order','order' => 10)) . '</td><td>order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.active','order' => 11)) . '</td><td>active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.show_in_menu','order' => 12)) . '</td><td>show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.viewed','order' => 13)) . '</td><td>viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.created','order' => 14)) . '</td><td>created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.modified','order' => 15)) . '</td><td>modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.action','order' => 16)) . '</td><td>action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.template_id','order' => 17)) . '</td><td>template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            
    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-articles');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/articles'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Content.alias',array('type' => 'hidden')) . 'alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Content.ContentDescription.name',array('type' => 'hidden')) . 'name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.3.Content.parent',array('type' => 'hidden')) . 'parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.4.Content.ContentDescription.description',array('type' => 'hidden')) . 'description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.5.Content.ContentDescription.short_description',array('type' => 'hidden')) . 'short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.6.Content.ContentDescription.meta_title',array('type' => 'hidden')) . 'meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.7.Content.ContentDescription.meta_description',array('type' => 'hidden')) . 'meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Content.ContentDescription.meta_keywords',array('type' => 'hidden')) . 'meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.9.Content.image',array('type' => 'hidden')) . 'image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.10.Content.order',array('type' => 'hidden')) . 'order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.11.Content.active',array('type' => 'hidden')) . 'active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.12.Content.show_in_menu',array('type' => 'hidden')) . 'show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.13.Content.viewed',array('type' => 'hidden')) . 'viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.14.Content.created',array('type' => 'hidden')) . 'created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.15.Content.modified',array('type' => 'hidden')) . 'modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.16.Content.action',array('type' => 'hidden')) . 'action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.17.Content.template_id',array('type' => 'hidden')) . 'template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();


echo '<!-- /Articles Tab End -->';
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('news');

echo '<!-- News Tab Start -->';

echo '<ul id="myTabNews" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-news',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-news',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('news');

echo $this->Admin->StartTabContent('export-news');

    echo $this->Form->create('ImportExport', array('id' => 'news_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/news'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.alias','readonly' => true,'order' => 1)) . '</td><td>alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.name','readonly' => true,'order' => 2)) . '</td><td>name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.parents','readonly' => true,'order' => 3)) . '</td><td>parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.description','order' => 4)) . '</td><td>description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.short_description','order' => 5)) . '</td><td>short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_title','order' => 6)) . '</td><td>meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_description','order' => 7)) . '</td><td>meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ContentDescription.meta_keywords','order' => 8)) . '</td><td>meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.image','order' => 9)) . '</td><td>image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.order','order' => 10)) . '</td><td>order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.active','order' => 11)) . '</td><td>active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.show_in_menu','order' => 12)) . '</td><td>show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.viewed','order' => 13)) . '</td><td>viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.created','order' => 14)) . '</td><td>created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.modified','order' => 15)) . '</td><td>modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.action','order' => 16)) . '</td><td>action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Content.template_id','order' => 17)) . '</td><td>template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            
    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-news');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/news'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' .  __('Required Fields: alias, name, parent.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Content.alias',array('type' => 'hidden')) . 'alias</td><td>' . __('Content alias. Alias must be unique for every content element. <span class="text-danger">Alias used for url generation of content. For example, if you set: test, url for this content element will be: http://your-store.com/content-type/test.html.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Content.ContentDescription.name',array('type' => 'hidden')) . 'name</td><td>' . __('Name.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.3.Content.parent',array('type' => 'hidden')) . 'parent</td><td>' . __('Content Category.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.4.Content.ContentDescription.description',array('type' => 'hidden')) . 'description</td><td>' . __('Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.5.Content.ContentDescription.short_description',array('type' => 'hidden')) . 'short_description</td><td>' . __('Short Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.6.Content.ContentDescription.meta_title',array('type' => 'hidden')) . 'meta_title</td><td>' . __('Meta Title.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.7.Content.ContentDescription.meta_description',array('type' => 'hidden')) . 'meta_description</td><td>' . __('Meta Description.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Content.ContentDescription.meta_keywords',array('type' => 'hidden')) . 'meta_keywords</td><td>' . __('Meta Keywords.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.9.Content.image',array('type' => 'hidden')) . 'image</td><td>' . __('Content Images.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.10.Content.order',array('type' => 'hidden')) . 'order</td><td>' . __('Sort Order.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.11.Content.active',array('type' => 'hidden')) . 'active</td><td>' . __('Content Status. 1 - Active. 0 - Inactive.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.12.Content.show_in_menu',array('type' => 'hidden')) . 'show_in_menu</td><td>' . __('Show In Menu. 1 - Yes. 0 - No.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.13.Content.viewed',array('type' => 'hidden')) . 'viewed</td><td>' . __('Content Viewed Count.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.14.Content.created',array('type' => 'hidden')) . 'created</td><td>' . __('Creation Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.15.Content.modified',array('type' => 'hidden')) . 'modified</td><td>' . __('Modification Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.16.Content.action',array('type' => 'hidden')) . 'action</td><td>' . __('Action. <span class="text-danger">You can delete content from your store. Set <strong>delete</strong> at this column.</span>') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.17.Content.template_id',array('type' => 'hidden')) . 'template_id</td><td>' . __('Template Id.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language_id', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Categories/Subcategories Delimiter'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();


echo '<!-- /News Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('customers');

echo '<!-- Customers Tab Start -->';

echo '<ul id="myTabCustomers" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-customers',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-customers',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('customers');

echo $this->Admin->StartTabContent('export-customers');

    echo $this->Form->create('ImportExport', array('id' => 'customers_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/customers'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' . __('Required Fields: email, password.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Customer.email','readonly' => true,'order' => 1)) . '</td><td>email</td><td>' . __('Email. <span class="text-danger">Email must be unique for every customer.</span>') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Customer.password','order' => 2)) . '</td><td>password</td><td>' . __('Password.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Customer.name','order' => 3)) . '</td><td>name</td><td>' . __('Name.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.ship_name','order' => 4)) . '</td><td>ship_name</td><td>' . __('Shipping Name.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.ship_line_1','order' => 5)) . '</td><td>ship_line_1</td><td>' . __('Address.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.ship_line_2','order' => 6)) . '</td><td>ship_line_2</td><td>' . __('Additional Info.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.ship_city','order' => 7)) . '</td><td>ship_city</td><td>' . __('City.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.ship_state','order' => 8)) . '</td><td>ship_state</td><td>' . __('State.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.ship_country','order' => 9)) . '</td><td>ship_country</td><td>' . __('Country.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.ship_zip','order' => 10)) . '</td><td>ship_zip</td><td>' . __('ZIP.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.phone','order' => 11)) . '</td><td>phone</td><td>' . __('Phone.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.created','order' => 12)) . '</td><td>created</td><td>' . __('Customer Creation Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'AddressBook.modified','order' => 13)) . '</td><td>modified</td><td>' . __('Customer Modification Date.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            
    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.groups_customer_id',array(
				'type' => 'select',
				'label' => __('Group')
				,'options' => $groups
                                ));   

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-customers');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/customers'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' . __('Required Fields: email, password.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Customer.email',array('type' => 'hidden')) . 'email</td><td>' . __('Email. <span class="text-danger">Email must be unique for every customer.</span>') . '</tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.2.Customer.password',array('type' => 'hidden')) . 'password</td><td>' . __('Password.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.3.Customer.name',array('type' => 'hidden')) . 'name</td><td>' . __('Name.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.4.Customer.AddressBook.ship_name',array('type' => 'hidden')) . 'ship_name</td><td>' . __('Shipping Name.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.5.Customer.AddressBook.ship_line_1',array('type' => 'hidden')) . 'ship_line_1</td><td>' . __('Address.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.6.Customer.AddressBook.ship_line_2',array('type' => 'hidden')) . 'ship_line_2</td><td>' . __('Additional Info.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.7.Customer.AddressBook.ship_city',array('type' => 'hidden')) . 'ship_city</td><td>' . __('City.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.8.Customer.AddressBook.ship_state',array('type' => 'hidden')) . 'ship_state</td><td>' . __('State.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.9.Customer.AddressBook.ship_country',array('type' => 'hidden')) . 'ship_country</td><td>' . __('Country.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.10.Customer.AddressBook.ship_zip',array('type' => 'hidden')) . 'ship_zip</td><td>' . __('ZIP.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.11.Customer.AddressBook.phone',array('type' => 'hidden')) . 'phone</td><td>' . __('Phone.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.12.Customer.AddressBook.created',array('type' => 'hidden')) . 'created</td><td>' . __('Customer Creation Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.13.Customer.AddressBook.modified',array('type' => 'hidden')) . 'modified</td><td>' . __('Customer Modification Date.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));

    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo '<!-- /Customers Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('orders');

echo '<!-- Orders Tab Start -->';

echo '<ul id="myTabOrders" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-orders',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-orders',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs('orders');

echo $this->Admin->StartTabContent('export-orders');

    echo $this->Form->create('ImportExport', array('id' => 'orders_form_export', 'class' => 'form-horizontal', 'url' => '/import_export/export/orders'));

echo '

<h3>' . __('Available Fields') . '</h3>

<div><span class="text-warning">' . __('Required Fields: id, total.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th align="center">' . __('Export') . '</th><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.id','readonly' => true,'order' => 1)) . '</td><td>id</td><td>' . __('Order Number.') . '</td></tr>
	<tr class="warning"><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.total','readonly' => true,'order' => 2)) . '</td><td>total</td><td>' . __('Order Total.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.shipping','order' => 3)) . '</td><td>shipping</td><td>' . __('Shipping.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.tax','order' => 4)) . '</td><td>tax</td><td>' . __('Tax Id.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.order_status_id','order' => 5)) . '</td><td>order_status_id</td><td>' . __('Order Status Id.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.bill_name','order' => 6)) . '</td><td>bill_name</td><td>' . __('Billing Name.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.bil_line_1','order' => 7)) . '</td><td>bil_line_1</td><td>' . __('Billing Address.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.bill_line_2','order' => 8)) . '</td><td>bill_line_2</td><td>' . __('Billing Additional Info.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.bill_city','order' => 9)) . '</td><td>bill_city</td><td>' . __('Billing City.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.bill_state','order' => 10)) . '</td><td>bill_state</td><td>' . __('Billing State.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.bill_country','order' => 11)) . '</td><td>bill_country</td><td>' . __('Billing Country.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.bill_zip','order' => 12)) . '</td><td>bill_zip</td><td>' . __('Billing ZIP.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.email','order' => 13)) . '</td><td>email</td><td>' . __('Email.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.phone','order' => 14)) . '</td><td>phone</td><td>' . __('Phone.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.created','order' => 15)) . '</td><td>created</td><td>' . __('Order Date.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.customer_id','order' => 16)) . '</td><td>customer_id</td><td>' . __('Customer Id.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'PaymentMethod.name','order' => 17)) . '</td><td>payment_method_id</td><td>' . __('Payment Method.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'ShippingMethod.name','order' => 18)) . '</td><td>shipping_method_id</td><td>' . __('Shipping Method.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.ship_name','order' => 19)) . '</td><td>ship_name</td><td>' . __('Shipping Name.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.ship_line_1','order' => 20)) . '</td><td>ship_line_1</td><td>' . __('Shipping Address.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.ship_line_2','order' => 21)) . '</td><td>ship_line_2</td><td>' . __('Shipping Additional Info.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.ship_city','order' => 22)) . '</td><td>ship_city</td><td>' . __('Shipping City.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.ship_state','order' => 23)) . '</td><td>ship_state</td><td>' . __('Shipping State.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.ship_country','order' => 24)) . '</td><td>ship_country</td><td>' . __('Shipping Country.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.ship_zip','order' => 25)) . '</td><td>ship_zip</td><td>' . __('Shipping ZIP.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.company_name','order' => 26)) . '</td><td>company_name</td><td>' . __('Company Name.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.company_info','order' => 27)) . '</td><td>company_info</td><td>' . __('Additional Company Info.') . '</td></tr>
	<tr><td>' . $this->element('../ImportExport/checkbox_field',array('name_field' => 'Order.company_vat','order' => 28)) . '</td><td>company_vat</td><td>' . __('Company VAT.') . '</td></tr>
    </tbody>
</table>

<a class="btn btn-default" data-switch-toggle="state"><i class="cus-arrow-refresh"></i> ' . __('Toggle All') . '</a>
            
';            

	echo $this->Form->input('ImportExport.date_start', 
		array(
			'label' => __('Order Date From'),
			'type' => 'text',
			'dateFormat' => 'Y-m-d H:i:s',
			'id' => 'date_start'
		));

	echo $this->Form->input('ImportExport.date_end', 
		array(
			'label' => __('To'),
			'type' => 'text',
			'id' => 'date_end'
		));

    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));


    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-orders');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'url' => '/import_export/import/orders'));

echo '

<h3>' . __('Allowed Fields') . '</h3>

<div><span class="text-warning">' . __('Required Fields: id, total.') . '</span></div>

<table class="table sortable_list">
    <thead>
        <tr><th>' . __('Name') . '</th><th>' . __('Description') . '</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Order.id',array('type' => 'hidden')) . 'id</td><td>' . __('Order Number.') . '</td></tr>
	<tr class="warning"><td>' . $this->Form->input('Fields.1.Order.total',array('type' => 'hidden')) . 'total</td><td>' . __('Order Total.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.shipping',array('type' => 'hidden')) . 'shipping</td><td>' . __('Shipping.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.tax',array('type' => 'hidden')) . 'tax</td><td>' . __('Tax Id.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.order_status_id',array('type' => 'hidden')) . 'order_status_id</td><td>' . __('Order Status Id.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.bill_name',array('type' => 'hidden')) . 'bill_name</td><td>' . __('Billing Name.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.bil_line_1',array('type' => 'hidden')) . 'bil_line_1</td><td>' . __('Billing Address.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.bill_line_2',array('type' => 'hidden')) . 'bill_line_2</td><td>' . __('Billing Additional Info.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.bill_city',array('type' => 'hidden')) . 'bill_city</td><td>' . __('Billing City.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.bill_state',array('type' => 'hidden')) . 'bill_state</td><td>' . __('Billing State.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.bill_country',array('type' => 'hidden')) . 'bill_country</td><td>' . __('Billing Country.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.bill_zip',array('type' => 'hidden')) . 'bill_zip</td><td>' . __('Billing ZIP.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.email',array('type' => 'hidden')) . 'email</td><td>' . __('Email.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.phone',array('type' => 'hidden')) . 'phone</td><td>' . __('Phone.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.created',array('type' => 'hidden')) . 'created</td><td>' . __('Order Date.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.customer_id',array('type' => 'hidden')) . 'customer_id</td><td>' . __('Customer Id.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.payment_method_id',array('type' => 'hidden')) . 'payment_method_id</td><td>' . __('Payment Method.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.shipping_method_id',array('type' => 'hidden')) . 'shipping_method_id</td><td>' . __('Shipping Method.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.ship_name',array('type' => 'hidden')) . 'ship_name</td><td>' . __('Shipping Name.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.ship_line_1',array('type' => 'hidden')) . 'ship_line_1</td><td>' . __('Shipping Address.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.ship_line_2',array('type' => 'hidden')) . 'ship_line_2</td><td>' . __('Shipping Additional Info.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.ship_city',array('type' => 'hidden')) . 'ship_city</td><td>' . __('Shipping City.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.ship_state',array('type' => 'hidden')) . 'ship_state</td><td>' . __('Shipping State.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.ship_country',array('type' => 'hidden')) . 'ship_country</td><td>' . __('Shipping Country.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.ship_zip',array('type' => 'hidden')) . 'ship_zip</td><td>' . __('Shipping ZIP.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.company_name',array('type' => 'hidden')) . 'company_name</td><td>' . __('Company Name.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.company_info',array('type' => 'hidden')) . 'company_info</td><td>' . __('Additional Company Info.') . '</td></tr>
	<tr><td>' . $this->Form->input('Fields.1.Order.company_vat',array('type' => 'hidden')) . 'company_vat</td><td>' . __('Company VAT.') . '</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('CSV File Delimiter'),
					'value' => ';'
				));

    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();


echo '<!-- /Orders Tab End -->';

echo $this->Admin->EndTabContent();


echo $this->Admin->EndTabs();

echo $this->Admin->ShowPageHeaderEnd();

?>