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
	'jquery/plugins/multiselect/bootstrap-multiselect.js',
	'jquery/plugins/jquery-ui-min.js',
	'jquery/plugins/jquery-ui/' . $fname,
	'selectall.js'
), array('inline' => false));

$this->Html->css(array('jquery/plugins/multiselect/bootstrap-multiselect.css','jquery-ui.css'), null, array('inline' => false));
?>
<style type="text/css">
.ui-sortable tr {
	cursor:pointer;
}
		
.ui-sortable tr:hover {
	background:rgba(244,251,17,0.45);
}

</style>
<?php echo $this->Html->scriptBlock('
    $(document).ready(function() {

		$(function() {
			$( "#date_start" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
			$( "#date_end" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		});


        $("#selected_content").multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
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
	$("#diagnosis_list tbody").sortable({
    	helper: fixHelperModified,
		stop: function(event,ui) {renumber_table("#diagnosis_list")}
	}).disableSelection();


	//Delete button in table rows
	$("table").on("click",".btn-delete",function() {
		tableID = "#" + $(this).closest("table").attr("id");
		r = confirm("Delete this item?");
		if(r) {
			$(this).closest("tr").remove();
			renumber_table(tableID);
			}
	});

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
echo $this->Admin->CreateTab('products',__('Товары',true), 'cus-table');
echo $this->Admin->CreateTab('manufacturers',__('Производители',true), 'cus-tag-blue');
echo $this->Admin->CreateTab('categories',__('Категории',true), 'cus-report');
echo $this->Admin->CreateTab('pages',__('Страницы',true), 'cus-page');
echo $this->Admin->CreateTab('articles',__('Статьи',true), 'cus-book-add');
echo $this->Admin->CreateTab('news',__('Новости',true), 'cus-newspaper');
echo $this->Admin->CreateTab('customers',__('Покупатели',true), 'cus-user');
echo $this->Admin->CreateTab('orders',__('Заказы',true), 'cus-cart');
echo $this->Admin->CreateTab('readme',__('ReadMe',true), 'cus-wrench');
echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('products');

echo '<!-- Products Tab Start -->';

echo '<ul id="myTabProducts" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-products',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-products',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-products');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>model</td><td>Артикул. <span class="text-danger">С помощью артикула производится идентификация товаров магазина, т.е. артикул - это ключ. Если товар с указанным артикулом есть уже в магазине, информация по данному товару обновляется при импорте csv файла. Если в магазине не найден товар с указанным артикулом, добавляется новый товар.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название товара.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория товара. <span class="text-danger">К какой категории относится товара. Указывается название категории, подкатегории. Например добаляет новый телефон в категорию Смартфоны, пишем: Смартфоны. Добавляем товар в подкатегорию Аксессуары категории Смартфоны, пишем: Cмартфоны/Аксессуары.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">4</td><td>alias</td><td>Псевдоним товара. <span class="text-danger">Проще говоря, псевдоним - это url адрес для товара, именно на основе псевдонима строится url адрес товара в магазине. Например, если укажите: tovar, то url адрес данного товара в магазине будет: http://магазин.ру/product/tovar.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>sku</td><td>SKU - идентификатор товарной позиции, учетная единица, складской номер.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>stock</td><td>Количество товара на складе.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>price</td><td>Цена. <span class="text-danger">Разделитель целых чисел - точка. Например, цена товара 1000 рублей 50 копеек, пишем как 1000.50</span></td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>weight</td><td>Вес товара в граммах. <span class="text-danger">Например, вес товара товара 110 грамм, пишем как 0.110</span></td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>label</td><td>Ярлык товара, например: Новинка, Хит, Распродажа и т.д.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>manufacturer</td><td>Производитель. Указываем название производителя товара (брэнд).</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>description</td><td>Описание товара.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>short_description</td><td>Краткое описание товара.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>meta_title</td><td>Заголовок Meta Title.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>meta_description</td><td>Значение для тэга Meta Description.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">16</td><td>image</td><td>Картинка товара. Название файла картинки товара, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">17</td><td>order</td><td>Порядок сортировки.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">18</td><td>active</td><td>Активный товар или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">19</td><td>show_in_menu</td><td>Показывать товар в меню. Можно выводить товар в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">20</td><td>yml_export</td><td>Экспортировать товар в Яндекс Маркет или не экспортировать. 1 - экспортировать. 0 - не экспортировать.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">21</td><td>viewed</td><td>Количество просмотров товара.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">22</td><td>created</td><td>Дата создания товара.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">23</td><td>modified</td><td>Дата модификации товара.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять товары из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того товара, который Вы хотите удалить.</span></td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>tax_id</td><td>Налог.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>template_id</td><td>Шаблон товара.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">3</td><td>is_group</td><td>Сгруппированный товар.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>id_group</td><td>Группа.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

    
		echo $this->Form->input('ImportExport.parent_id', 
					array(
						'type' => 'select',
						'id' => 'selected_content',
			   		'label' => __('Категории'),
						'options' => $this->requestAction('/contents/admin_parents_tree/'),
						'escape' => false,
						'empty' => array(0 => __('Все категории'))
               ), array('multiple' => true));

	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-products');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля model, name, parent, alias - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>model</td><td>Артикул. <span class="text-danger">С помощью артикула производится идентификация товаров магазина, т.е. артикул - это ключ. Если товар с указанным артикулом есть уже в магазине, информация по данному товару обновляется при импорте csv файла. Если в магазине не найден товар с указанным артикулом, добавляется новый товар.</span></td></tr>
	<tr class="warning"><td>name</td><td>Название товара.</td></tr>
	<tr class="warning"><td>parent</td><td>Категория товара. <span class="text-danger">К какой категории относится товара. Указывается название категории, подкатегории. Например добаляет новый телефон в категорию Смартфоны, пишем: Смартфоны. Добавляем товар в подкатегорию Аксессуары категории Смартфоны, пишем: Cмартфоны/Аксессуары.</span></td></tr>
	<tr class="warning"><td>alias</td><td>Псевдоним товара. <span class="text-danger">Проще говоря, псевдоним - это url адрес для товара, именно на основе псевдонима строится url адрес товара в магазине. Например, если укажите: tovar, то url адрес данного товара в магазине будет: http://магазин.ру/product/tovar.html.</span></td></tr>
	<tr><td>sku</td><td>SKU - идентификатор товарной позиции, учетная единица, складской номер.</td></tr>
	<tr><td>stock</td><td>Количество товара на складе.</td></tr>
	<tr><td>price</td><td>Цена. <span class="text-danger">Разделитель целых чисел - точка. Например, цена товара 1000 рублей 50 копеек, пишем как 1000.50</span></td></tr>
	<tr><td>weight</td><td>Вес товара в граммах. <span class="text-danger">Например, вес товара товара 110 грамм, пишем как 0.110</span></td></tr>
	<tr><td>label</td><td>Ярлык товара, например: Новинка, Хит, Распродажа и т.д.</td></tr>
	<tr><td>manufacturer</td><td>Производитель. Указываем название производителя товара (брэнд).</td></tr>
	<tr><td>description</td><td>Описание товара.</td></tr>
	<tr><td>short_description</td><td>Краткое описание товара.</td></tr>
	<tr><td>meta_title</td><td>Заголовок Meta Title.</td></tr>
	<tr><td>meta_description</td><td>Значение для тэга Meta Description.</td></tr>
	<tr><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td></tr>
	<tr><td>image</td><td>Картинка товара. Название файла картинки товара, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td></tr>
	<tr><td>order</td><td>Порядок сортировки.</td></tr>
	<tr><td>active</td><td>Активный товар или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td></tr>
	<tr><td>show_in_menu</td><td>Показывать товар в меню. Можно выводить товар в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td></tr>
	<tr><td>yml_export</td><td>Экспортировать товар в Яндекс Маркет или не экспортировать. 1 - экспортировать. 0 - не экспортировать.</td></tr>
	<tr><td>viewed</td><td>Количество просмотров товара.</td></tr>
	<tr><td>created</td><td>Дата создания товара.</td></tr>
	<tr><td>modified</td><td>Дата модификации товара.</td></tr>
	<tr><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять товары из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того товара, который Вы хотите удалить.</span></td></tr>
	<tr><td>tax_id</td><td>Налог.</td></tr>
	<tr><td>template_id</td><td>Шаблон товара.</td></tr>
	<tr><td>is_group</td><td>Сгруппированный товар.</td></tr>
	<tr><td>id_group</td><td>Группа.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo '<!-- /Products Tab End -->';
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('manufacturers');

echo '<!-- Manufacturers Tab Start -->';

echo '<ul id="myTabManufacturers" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-manufacturers',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-manufacturers',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-manufacturers');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>description</td><td>Описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>short_description</td><td>Краткое описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>meta_title</td><td>Заголовок Meta Title.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>meta_description</td><td>Значение для тэга Meta Description.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>order</td><td>Порядок сортировки.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>viewed</td><td>Количество просмотров элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>created</td><td>Дата создания элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>modified</td><td>Дата модификации элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>template_id</td><td>Шаблон элемента.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-manufacturers');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля alias, name, parent - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td></tr>
	<tr class="warning"><td>name</td><td>Название.</td></tr>
	<tr class="warning"><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td></tr>
	<tr><td>description</td><td>Описание.</td></tr>
	<tr><td>short_description</td><td>Краткое описание.</td></tr>
	<tr><td>meta_title</td><td>Заголовок Meta Title.</td></tr>
	<tr><td>meta_description</td><td>Значение для тэга Meta Description.</td></tr>
	<tr><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td></tr>
	<tr><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td></tr>
	<tr><td>order</td><td>Порядок сортировки.</td></tr>
	<tr><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td></tr>
	<tr><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td></tr>
	<tr><td>viewed</td><td>Количество просмотров элемента.</td></tr>
	<tr><td>created</td><td>Дата создания элемента.</td></tr>
	<tr><td>modified</td><td>Дата модификации элемента.</td></tr>
	<tr><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td></tr>
	<tr><td>template_id</td><td>Шаблон элемента.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
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

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-categories');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>description</td><td>Описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>short_description</td><td>Краткое описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>meta_title</td><td>Заголовок Meta Title.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>meta_description</td><td>Значение для тэга Meta Description.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>order</td><td>Порядок сортировки.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>viewed</td><td>Количество просмотров элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>created</td><td>Дата создания элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>modified</td><td>Дата модификации элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>template_id</td><td>Шаблон элемента.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-categories');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля alias, name, parent - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td></tr>
	<tr class="warning"><td>name</td><td>Название.</td></tr>
	<tr class="warning"><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td></tr>
	<tr><td>description</td><td>Описание.</td></tr>
	<tr><td>short_description</td><td>Краткое описание.</td></tr>
	<tr><td>meta_title</td><td>Заголовок Meta Title.</td></tr>
	<tr><td>meta_description</td><td>Значение для тэга Meta Description.</td></tr>
	<tr><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td></tr>
	<tr><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td></tr>
	<tr><td>order</td><td>Порядок сортировки.</td></tr>
	<tr><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td></tr>
	<tr><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td></tr>
	<tr><td>viewed</td><td>Количество просмотров элемента.</td></tr>
	<tr><td>created</td><td>Дата создания элемента.</td></tr>
	<tr><td>modified</td><td>Дата модификации элемента.</td></tr>
	<tr><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td></tr>
	<tr><td>template_id</td><td>Шаблон элемента.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
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

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-pages');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>description</td><td>Описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>short_description</td><td>Краткое описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>meta_title</td><td>Заголовок Meta Title.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>meta_description</td><td>Значение для тэга Meta Description.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>order</td><td>Порядок сортировки.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>viewed</td><td>Количество просмотров элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>created</td><td>Дата создания элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>modified</td><td>Дата модификации элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>template_id</td><td>Шаблон элемента.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-pages');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля alias, name, parent - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td></tr>
	<tr class="warning"><td>name</td><td>Название.</td></tr>
	<tr class="warning"><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td></tr>
	<tr><td>description</td><td>Описание.</td></tr>
	<tr><td>short_description</td><td>Краткое описание.</td></tr>
	<tr><td>meta_title</td><td>Заголовок Meta Title.</td></tr>
	<tr><td>meta_description</td><td>Значение для тэга Meta Description.</td></tr>
	<tr><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td></tr>
	<tr><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td></tr>
	<tr><td>order</td><td>Порядок сортировки.</td></tr>
	<tr><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td></tr>
	<tr><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td></tr>
	<tr><td>viewed</td><td>Количество просмотров элемента.</td></tr>
	<tr><td>created</td><td>Дата создания элемента.</td></tr>
	<tr><td>modified</td><td>Дата модификации элемента.</td></tr>
	<tr><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td></tr>
	<tr><td>template_id</td><td>Шаблон элемента.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
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

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-articles');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>description</td><td>Описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>short_description</td><td>Краткое описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>meta_title</td><td>Заголовок Meta Title.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>meta_description</td><td>Значение для тэга Meta Description.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>order</td><td>Порядок сортировки.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>viewed</td><td>Количество просмотров элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>created</td><td>Дата создания элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>modified</td><td>Дата модификации элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>template_id</td><td>Шаблон элемента.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-articles');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля alias, name, parent - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td></tr>
	<tr class="warning"><td>name</td><td>Название.</td></tr>
	<tr class="warning"><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td></tr>
	<tr><td>description</td><td>Описание.</td></tr>
	<tr><td>short_description</td><td>Краткое описание.</td></tr>
	<tr><td>meta_title</td><td>Заголовок Meta Title.</td></tr>
	<tr><td>meta_description</td><td>Значение для тэга Meta Description.</td></tr>
	<tr><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td></tr>
	<tr><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td></tr>
	<tr><td>order</td><td>Порядок сортировки.</td></tr>
	<tr><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td></tr>
	<tr><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td></tr>
	<tr><td>viewed</td><td>Количество просмотров элемента.</td></tr>
	<tr><td>created</td><td>Дата создания элемента.</td></tr>
	<tr><td>modified</td><td>Дата модификации элемента.</td></tr>
	<tr><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td></tr>
	<tr><td>template_id</td><td>Шаблон элемента.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
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

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-news');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>description</td><td>Описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>short_description</td><td>Краткое описание.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>meta_title</td><td>Заголовок Meta Title.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>meta_description</td><td>Значение для тэга Meta Description.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>order</td><td>Порядок сортировки.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>viewed</td><td>Количество просмотров элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>created</td><td>Дата создания элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>modified</td><td>Дата модификации элемента.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>template_id</td><td>Шаблон элемента.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-news');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля alias, name, parent - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td></tr>
	<tr class="warning"><td>name</td><td>Название.</td></tr>
	<tr class="warning"><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td></tr>
	<tr><td>description</td><td>Описание.</td></tr>
	<tr><td>short_description</td><td>Краткое описание.</td></tr>
	<tr><td>meta_title</td><td>Заголовок Meta Title.</td></tr>
	<tr><td>meta_description</td><td>Значение для тэга Meta Description.</td></tr>
	<tr><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td></tr>
	<tr><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td></tr>
	<tr><td>order</td><td>Порядок сортировки.</td></tr>
	<tr><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td></tr>
	<tr><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td></tr>
	<tr><td>viewed</td><td>Количество просмотров элемента.</td></tr>
	<tr><td>created</td><td>Дата создания элемента.</td></tr>
	<tr><td>modified</td><td>Дата модификации элемента.</td></tr>
	<tr><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td></tr>
	<tr><td>template_id</td><td>Шаблон элемента.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));

	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.cat_delimiter', 
				array(
					'label' => __('Разделитель категории/подкатегории'),
					'value' => '/'
				));


    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
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

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-customers');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>email</td><td>Email адрес покупателя. <span class="text-danger">Данное поле является ключом - проверяется, если клиента с таким email нет, то добавляется новый клиент, если есть - обновляются данные покупателя.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>password</td><td>Пароль.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">3</td><td>name</td><td>Имя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>ship_name</td><td>Имя получателя заказа.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>ship_line_1</td><td>Адрес.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>ship_line_2</td><td>Дополнительная адресная информация.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>ship_city</td><td>Город.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>ship_state</td><td>Регион.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>ship_country</td><td>Страна.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>ship_zip</td><td>Почтовый индекс.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>phone</td><td>Телефон.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>created</td><td>Дата регистрации покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>modified</td><td>Дата модификации покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td colspan="4">Все доступные поля уже добавлены в экспортируемые, готовы к выгрузке в csv файл.</td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


	echo $this->Form->input('ImportExport.groups_customer_id',array(
				'type' => 'select',
				'label' => __('Group')
				,'options' => $groups
                                ));   

    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-customers');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля email, password - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>email</td><td>Email адрес покупателя.</tr>
	<tr class="warning"><td>password</td><td>Пароль.</td></tr>
	<tr><td>name</td><td>Имя.</td></tr>
	<tr><td>ship_name</td><td>Имя получателя заказа.</td></tr>
	<tr><td>ship_line_1</td><td>Адрес.</td></tr>
	<tr><td>ship_line_2</td><td>Дополнительная адресная информация.</td></tr>
	<tr><td>ship_city</td><td>Город.</td></tr>
	<tr><td>ship_state</td><td>Регион.</td></tr>
	<tr><td>ship_country</td><td>Страна.</td></tr>
	<tr><td>ship_zip</td><td>Почтовый индекс.</td></tr>
	<tr><td>phone</td><td>Телефон.</td></tr>
	<tr><td>created</td><td>Дата регистрации покупателя.</td></tr>
	<tr><td>modified</td><td>Дата модификации покупателя.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));

    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
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

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-orders');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>id</td><td>Номер заказа.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr class="warning"><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>total</td><td>Сумма заказа.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">3</td><td>shipping</td><td>Стоимость доставки.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>tax</td><td>Налог.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>order_status_id</td><td>Имя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>bill_name</td><td>Имя покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>bil_line_1</td><td>Адрес покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>bill_line_2</td><td>Дополнительная адресная информация покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>bill_city</td><td>Город покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>bill_state</td><td>Регион покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>bill_country</td><td>Страна покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>bill_zip</td><td>Почтовый индекс покупателя.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>email</td><td>Email адрес.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">14</td><td>phone</td><td>Телефон.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">15</td><td>created</td><td>Дата заказа.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	 </tbody>
</table>

<a class="btn btn-delete btn-danger">Удалить выделенные</a> <a class="btn btn-delete btn-danger">Удалить все</a>
            
';            

echo '

<h3>Доступные поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">1</td><td>customer_id</td><td>Номер покупателя.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">2</td><td>payment_method_id</td><td>Способ оплаты.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">3</td><td>shipping_method_id</td><td>Способ доставки.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">4</td><td>ship_name</td><td>Имя получателя заказа.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>ship_line_1</td><td>Адрес получателя.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>ship_line_2</td><td>Дополнительная адресная информация получателя.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>ship_city</td><td>Город получателя.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>ship_state</td><td>Регион получателя.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>ship_country</td><td>Страна получателя.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>ship_zip</td><td>Почтовый индекс получателя.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>company_name</td><td>Название компании.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>company_info</td><td>Дополнительная информация о компании.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">13</td><td>compant_vat</td><td>ИНН компании.</td><td><a class="btn btn-delete btn-success">Добавить</a></td></tr>
    </tbody>
</table>

<a class="btn btn-success">Добавить выделенные</a> <a class="btn btn-success">Добавить все</a>
            
';            

	echo $this->Form->input('ImportExport.date_start', 
		array(
			'label' => __('Дата заказа от'),
			'type' => 'text',
			'dateFormat' => 'Y-m-d H:i:s',
			'id' => 'date_start'
		));

	echo $this->Form->input('ImportExport.date_end', 
		array(
			'label' => __('до'),
			'type' => 'text',
			'id' => 'date_end'
		));

    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));


    echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('import-orders');

    echo '<div class="alert alert-error"><i class="cus-error"></i> '.__('Don\'t forget backup your database before import at Admin - Tools - Database Backup.').'</div>';
    echo $this->Form->create('form_Import', array('enctype' => 'multipart/form-data', 'id' => 'contentform_import', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

echo '

<h3>Допустимые поля</h3>

<div><span class="text-warning">Поля id, total - должны в обязательном порядке присутствовать в импортируемом файле.</span></div>

<table class="table" id="diagnosis_list_">
    <thead>
        <tr><th>Название колонки</th><th>Описание</th></tr>
    </thead>
    <tbody>
	<tr class="warning"><td>id</td><td>Номер заказа.</td></tr>
	<tr class="warning"><td>total</td><td>Сумма заказа.</td></tr>
	<tr><td>shipping</td><td>Стоимость доставки.</td></tr>
	<tr><td>tax</td><td>Налог.</td></tr>
	<tr><td>order_status_id</td><td>Имя.</td></tr>
	<tr><td>bill_name</td><td>Имя покупателя.</td></tr>
	<tr><td>bil_line_1</td><td>Адрес покупателя.</td></tr>
	<tr><td>bill_line_2</td><td>Дополнительная адресная информация покупателя.</td></tr>
	<tr><td>bill_city</td><td>Город покупателя.</td></tr>
	<tr><td>bill_state</td><td>Регион покупателя.</td></tr>
	<tr><td>bill_country</td><td>Страна покупателя.</td></tr>
	<tr><td>bill_zip</td><td>Почтовый индекс покупателя.</td></tr>
	<tr><td>email</td><td>Email адрес.</td></tr>
	<tr><td>phone</td><td>Телефон.</td></tr>
	<tr><td>created</td><td>Дата заказа.</td></tr>
	<tr><td>customer_id</td><td>Номер покупателя.</td></tr>
	<tr><td>payment_method_id</td><td>Способ оплаты.</td></tr>
	<tr><td>shipping_method_id</td><td>Способ доставки.</td></tr>
	<tr><td>ship_name</td><td>Имя получателя заказа.</td></tr>
	<tr><td>ship_line_1</td><td>Адрес получателя.</td></tr>
	<tr><td>ship_line_2</td><td>Дополнительная адресная информация получателя.</td></tr>
	<tr><td>ship_city</td><td>Город получателя.</td></tr>
	<tr><td>ship_state</td><td>Регион получателя.</td></tr>
	<tr><td>ship_country</td><td>Страна получателя.</td></tr>
	<tr><td>ship_zip</td><td>Почтовый индекс получателя.</td></tr>
	<tr><td>company_name</td><td>Название компании.</td></tr>
	<tr><td>company_info</td><td>Дополнительная информация о компании.</td></tr>
	<tr><td>compant_vat</td><td>ИНН компании.</td></tr>
    </tbody>
</table>
            
';            

    
	echo $this->Form->input('ImportExport.delimiter', 
				array(
					'label' => __('Разделитель колонок в CSV'),
					'value' => ';'
				));

    echo $this->Form->file('submittedfile');


    echo '<br />' . $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submit'));
    echo $this->Form->end();

echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();


echo '<!-- /Orders Tab End -->';

echo $this->Admin->EndTabContent();


echo '<!-- Readme Tab Start -->';

echo $this->Admin->StartTabContent('readme');

?>
<pre style="background: #fff; border: 0; color: #000; font-size: 16px;font-family: Arial, Helvetica, sans-serif;">
Я тут подготовил внешний вид для нового импорта/экспорта, так же подготовил описание каждой закладки, т.е. как это всё должно работать.

В целом - суть осталась та же самая, что Вы уже делали в модуле import/export, т.е. работал с таблицами, с колонками таблиц, только нужно сделать в виде csv файлов, т.е. под каждую таблицу отдельный файл, а не лист внутри xls файла.

Добавил описание для каждой колонки + упрощён ввод категории, к которой относится товар, в общем, я описал всё ниже, посмотрите.
Надеюсь, что смысл ясен.

Самая сложная колонка - Товары, а все остальные закладки в общем-то идентичны, упрощённый вариант закладки Товары, можно скачать copy-paste практически.

Импорт/экспорт - Админка - Содержание - Импорт/экспорт - <b>http://demo2.vamshop.ru/import_export/admin/</b>
<b>http://demo2.vamshop.ru/admin
admin
password</b>

В коде <b>/app/View/ImportExport.ctp</b> я добавил комментарии, что б проще было разобраться, каждая закладка начинается с комментариев:

echo '&lt;!-- Products Tab Start --&gt;';<br />заканчивается:<br />echo '&lt;!-- /Products Tab End --&gt;';<br /><br />Тоже самое и для других:<br /><br />начинается:<br />echo '&lt;!-- Manufacturers Tab Start --&gt;';<br />заканчивается:<br />echo '&lt;!-- /Manufacturers Tab End --&gt;';

и т.д.

<b>Закладка товары:</b>

Экспорт настраиваемый, т.е. можно выбирать, какие колонки выгружать и в каком порядке, можно перетягиванием колонок мышкой сортировать, в каком порядке колонки выгрузятся в файл.

Экспорт настраивается двумя таблицами: <b>Экспортируемые поля</b> и <b>Доступные поля</b> + <b>ниже настройки</b> типа разделителя csv, ограничения выгрузки, т.е. выгружать только определённую категорию. Выбор языка.

Сортировка сделана с помощью jQueryUI Sortable - http://jqueryui.com/sortable/
Что б запоминать отсортированный порядок, наверное можно использовать jQuery Cookie, который уже есть в /app/webroot/js/jquery/plugins/jquery.cookie.js
А может и что-то другое типа local storage, думаю, что Вам виднее.
Выбор категорий в настройках тоже нужно удобно сделать, например с помощью - boostrap multiselect, вот пример - http://davidstutz.github.io/bootstrap-multiselect/#post
т.е. там в примере в выборе есть поиск и Select all, вроде бы удобно, т.е. смысл в том, что б выбрать сразу несколько категорий. Если как-то проще можно сделать, сделайте проще. Это как вариант.

Таблицы Экспортируемые поля и Доступные поля должны быть связаны между собой.

т.е. в таблице Экспортируемые поля есть четыре обязательных поля, которые удалять нельзя, это как бы идентификационные данные товаров и обязательный минимум. 
Так же есть и другие необязательные поля, которые можно удалять, добавлять.
Нажимаем Удалить и удалённое поле должно перемещаться из таблицы Экспортируемые поля в Доступные поля, т.е. мы убрали это поле из выгрузки и вернули в список доступных полей.

В таблице <b>Доступные поля</b> выводятся все поля доступные для выгрузки (грубо говоря, это список колонок в таблицах), кнопка Добавить перемещает их в выгрузку, т.е. в таблицу Экспортируемые поля.

В таблице <b>Экспортируемые поля</b> в закладке Товары описание колонок таблиц, т.е. название колонки и описание текстом, что это за колонка:
contents
content_descriptions
content_products
content_images

Импорт/экспорт товаров работает только с этими таблицами.

Описаны практически все колонки эти таблиц.

Кроме пяти колонок, которые не соответствуют колонкам в базе, созданы для удобства пользователей:
parent
manufacturer
label
image
action

parent - это колонка parent_id в contents таблице.
Она нужна для "человеческой" записи названия категории, к которой относится товар, т.е. что б не в виде id номера категорию записывать как сейчас для импорт/экспорта, а что б можно было название категории/подкатегории написать словом, понятно, что б не выискивать id номера.

Например Смартфоны, значит что товар надо добавить в категорию Смартфоны.

Так же можно путь указывать категории-подкатегории, например есть указать: Смартфоны/Аксессуары, то товар добавиться в подкатегорию Аксессуары, которая внутри категории Смартфоны.
Указывать полный путь категорий/подкатегорий, вот тут я не знаю, я думаю, что эту возможность полезно иметь, а не только прописывать категорию, к которой относится товар.
А то ведь могут быть одинаковые названия подкатегорий внутри категорий и например если просто Аксессуары написать, а таких категорий в магазине несколько, не понятно, в какую имено попадёт товар.
Возможно, что попадёт не туда.
Вот я так посчитал, что полезно будет иметь возможность прописать и категорий и подкатегорию, что б точно знать, что товар попадёт в нужную категорию.

manufacturer - это колонка manufacturer_id в таблице content_products, т.е. тоже создана для удобной записи производителя, что б не id номер писать, а просто название брэнда.

label - это колонка label_id в таблице content_products и связанная с ней таблица labels, где сидят описания для ярлыков, т.е. тоже создана для удобной записи ярлыка товара, что б не id номер писать, а просто название ярлыка товара. Ярлыки в Админке - Настройки - Ярлыки товара.

image - это работа с таблицей content_images, т.е. с картинками товара. можно указать как просто название файла картинки, так и url адрес картинки, может указывать несколько через точку с запятой, если указан url адрес, то скрипт должен брать картинки по url адрес и копировать в /app/webroot/img/content/ID-номер-товара/файл-картинки.

action - это колонка используется для удаления товара, т.е. через csv файл что б можно было удалить товары все сразу, если указано delete в колонке action - удаляется тот товар, у которого указано delete, т.е. чистятся таблицы contents, content_descriptions, content_products, content_images

<b>Импорт:</b>

в закладке импорт просто объединённая таблица, та же, что и в закладке Экспорт, т.е. описание всех колонок, которые могут быть в импортируемом файле + настройки для импортируемого файла, т.е. какой язык, какой разделитель csv, какой разделитель категорий/подкатегорий.


Все эти таблицы я нарисовал вручную, по идее, они практически полностью повторяют структуру таблиц и колонок в базе данных, просто добавлено ещё описание каждой колонки.
Наверное можно автоматизировать будет в модуле через php сделать вывод этих таблиц, добавив возможность добавления описания.

Я просто для примера показал, как оно примерно должно быть в готовом видет, с описанием каждой колонки.

<b>Закладки Производители, Категории, Страницы, Статьи, Новости абслютно одинаковые.</b>

Идентификатором для этих пяти закладок будет служить колонка alias - т.е. проверяем alias и id номер контента этого alias (content_type_id), если такая запись с таким alias есть и тип контента совпадает, т.е. например страница, то обновляем страницу.
Если страницы с таким alias нет - создаём новую по данным из csv файла.

Разница лишь в значении колонки contenty_type_id в таблице contents:

4 - категории
2 - страницы
5 - новости
6 - статьи
7 - производители

т.е. все эти 5 закладок работает с таблицами:
contents
contents_description
content_images

и каждый тип в свою таблицу запись вносит:
категория в content_categories
производитель в content_manufacturers
страница в content_pages
новость в content_news
статья в cotent_articles

Так же как и в товарах есть колонка parent, т.е. где указывается, к какой категории относится страница, новости, производитель, статья, категория.

<b>Закладка Покупатели:</b>

Должна объединять в одном файле две таблицы: customres и address_book

Идентификатором для покупателей будет служить колонка email - т.е. проверяем email, если такой покупатель с таким email есть то обновляем данные из csv файла.
Если нет пользователя с таким email - добавляем нового пользователя в customers и address_book таблицы.

В customers Имя, Email, Пароль.
В address_book данные для доставки.

Экспорт можно ограничить группой клиентов, а можно всех выгрузить, т.е. если группу не выбираем - выгружаются все покупатели.
Если выбираем - только выбранной группы.

<b>Закладка Заказы:</b>

Здесь просто импорт/экспорт из таблицы orders, в закладке экспорт добавлена опция Дата заказ от-до, т.е. можно ограничить датой выгрузку, например выбрать выгрузку только заказов за текущей месяц, за год и т.д.

Да, понятно, что не затрагиваются order_comments, order_products

Но это наверное и не надо, я так думаю, что сложно будет в один csv файл с заказами добавить комментарии к заказу, заказанные товары, просто импорт/экспорт основной информации о заказах, т.е. таблицы orders
Кто заказывал, сумма заказа, думаю, что этого достаточно.


</pre>
<?php
echo $this->Admin->EndTabContent();

echo '<!-- /Readme Tab End -->';


echo $this->Admin->EndTabs();

echo $this->Admin->ShowPageHeaderEnd();

?>