<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'jquery/plugins/multiselect/bootstrap-multiselect.js',
	'jquery/plugins/jquery-ui-min.js',
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
<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-database-refresh');

echo '<ul id="myTab" class="nav nav-tabs">';
echo $this->Admin->CreateTab('products',__('Товары',true), 'cus-table');
echo $this->Admin->CreateTab('brands',__('Производители',true), 'cus-tag-blue');
echo $this->Admin->CreateTab('categories',__('Категории',true), 'cus-report');
echo $this->Admin->CreateTab('pages',__('Страницы',true), 'cus-page');
echo $this->Admin->CreateTab('articles',__('Статьи',true), 'cus-book-add');
echo $this->Admin->CreateTab('news',__('Новости',true), 'cus-newspaper');
echo $this->Admin->CreateTab('customers',__('Покупатели',true), 'cus-user');
echo $this->Admin->CreateTab('orders',__('Заказы',true), 'cus-cart');
echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('products');

echo '<!-- Products Tab Start -->';

echo '<ul id="myTabLang" class="nav nav-tabs">';
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
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>model</td><td>Артикул. <span class="text-danger">С помощью артикула производится идентификация товаров магазина, т.е. артикул - это ключ. Если товар с указанным артикулом есть уже в магазине, информация по данному товару обновляется при импорте csv файла. Если в магазине не найден товар с указанным артикулом, добавляется новый товар.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название товара.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория товара. <span class="text-danger">К какой категории относится товара. Указывается название категории, подкатегории. Например добаляет новый телефон в категорию Смартфоны, пишем: Смартфоны. Добавляем товар в подкатегорию Аксессуары категории Смартфоны, пишем: Cмартфоны/Аксессуары.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">4</td><td>alias</td><td>Псевдоним товара. <span class="text-danger">Проще говоря, псевдоним - это url адрес для товара, именно на основе псевдонима строится url адрес товара в магазине. Например, если укажите: tovar, то url адрес данного товара в магазине будет: http://магазин.ру/product/tovar.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">5</td><td>sku</td><td>SKU - идентификатор товарной позиции, учетная единица, складской номер.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">6</td><td>stock</td><td>Количество товара на складе.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">7</td><td>price</td><td>Цена. <span class="text-danger">Разделитель целых чисел - точка. Например, цена товара 1000 рублей 50 копеек, пишем как 1000.50</span></td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">8</td><td>weight</td><td>Вес товара в граммах. <span class="text-danger">Например, вес товара товара 110 грамм, пишем как 0.110</span></td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">9</td><td>label</td><td>Ярлык товара, например: Новинка, Хит, Распродажа и т.д.</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">10</td><td>brand</td><td>Производитель. Указываем название производителя товара (брэнд).</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">11</td><td>description</td><td>Описание товара</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify]["/></td><td class="priority">12</td><td>short_description</td><td>Краткое описание товара</td><td><a class="btn btn-delete btn-danger">Удалить</a></td></tr>
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

    
    echo '<div class="form-group input text">';
        echo '<label>'.__('Категории') . ':</label> <select class="form-control" name="data[form_Export][sel_content]" id="selected_content" multiple>';
        echo '<option value="0">' .  __('Все') . '</option>';
        foreach ($sel_content AS $k => $sel_category)
        {
            echo '<option value="' . $k . '">' . __($sel_category[0]) . '</option></div>';
        }
        echo '</select>';
    echo '</div>';

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
	<tr><td>brand</td><td>Производитель. Указываем название производителя товара (брэнд).</td></tr>
	<tr><td>description</td><td>Описание товара</td></tr>
	<tr><td>short_description</td><td>Краткое описание товара</td></tr>
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

echo $this->Admin->StartTabContent('brands');

echo '<!-- Brands Tab Start -->';

echo '<ul id="myTabBrands" class="nav nav-tabs">';
echo $this->Admin->CreateTab('export-brands',__('Export',true), 'cus-arrow-out');
echo $this->Admin->CreateTab('import-brands',__('Import',true), 'cus-arrow-in');
echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('export-brands');

    echo $this->Form->create('ImportExport', array('id' => 'contentform_export', 'class' => 'form-horizontal', 'action' => '/import_export/export/', 'url' => '/import_export/export/'));

echo '

<h3>Экспортируемые поля</h3>

<table class="table" id="diagnosis_list">
    <thead>
        <tr><th align="center"><input type="checkbox" onclick="checkAll(this)" /></th><th>Порядок</th><th>Название колонки</th><th>Описание</th><th>&nbsp;</th></tr>
    </thead>
    <tbody>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">1</td><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">2</td><td>name</td><td>Название.</td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
	<tr><td><input type="checkbox" name="data[Content][modify][]"  value="X" id="ContentModify][" disabled /></td><td class="priority">3</td><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td><td><a class="btn btn-delete btn-warning disabled">Обязательное поле</a></td></tr>
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

    
    echo '<div class="form-group input text">';
        echo '<label>'.__('Категории') . ':</label> <select class="form-control" name="data[form_Export][sel_content]" id="selected_content" multiple>';
        echo '<option value="0">' .  __('Все') . '</option>';
        foreach ($sel_content AS $k => $sel_category)
        {
            echo '<option value="' . $k . '">' . __($sel_category[0]) . '</option></div>';
        }
        echo '</select>';
    echo '</div>';

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

echo $this->Admin->StartTabContent('import-brands');

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
	<tr><td class="priority">1</td><td>alias</td><td>Псевдоним элемента. <span class="text-danger">Проще говоря, псевдоним - это url адрес для контента, именно на основе псевдонима строится url адрес в магазине. Например, если укажите: test, то url адрес данного элемента в магазине будет: http://магазин.ру/тип-контента/test.html.</span></td></tr>
	<tr><td class="priority">2</td><td>name</td><td>Название.</td></tr>
	<tr><td class="priority">3</td><td>parent</td><td>Категория, к которой относится элемент. <span class="text-danger">К какой категории относится элемент. Указывается название категории, подкатегории.</span></td></tr>
	<tr><td class="priority">4</td><td>description</td><td>Описание.</td></tr>
	<tr><td class="priority">5</td><td>short_description</td><td>Краткое описание.</td></tr>
	<tr><td class="priority">6</td><td>meta_title</td><td>Заголовок Meta Title.</td></tr>
	<tr><td class="priority">7</td><td>meta_description</td><td>Значение для тэга Meta Description.</td></tr>
	<tr><td class="priority">8</td><td>meta_keywords</td><td>Значение для тэга Meta Keywords.</td></tr>
	<tr><td class="priority">9</td><td>image</td><td>Картинка. Название файла картинки, если картинок несколько, указывайте через точку с запятой, например: image.png;image1.png. Кроме того, можно указывать URL адрес с картинкой, например: http://адрес.ру/image/kartinka.png;http://адрес.ру/image/kartinka1.png</td></tr>
	<tr><td class="priority">10</td><td>order</td><td>Порядок сортировки.</td></tr>
	<tr><td class="priority">11</td><td>active</td><td>Активный элемент или нет, т.е. виден посетителям или нет. 1 - виден, 0 - не виден.</td></tr>
	<tr><td class="priority">12</td><td>show_in_menu</td><td>Показывать элемент в меню. Можно выводить элемент в любом меню магазина, а не только в категории. 1 - показывать в меню, 0 - не показывать.</td></tr>
	<tr><td class="priority">13</td><td>viewed</td><td>Количество просмотров элемента.</td></tr>
	<tr><td class="priority">14</td><td>created</td><td>Дата создания элемента.</td></tr>
	<tr><td class="priority">15</td><td>modified</td><td>Дата модификации элемента.</td></tr>
	<tr><td class="priority">1</td><td>action</td><td>Действие. <span class="text-danger">С помощью данной колонки можно массово удалять элементы из интернет-магазина. Укажите в данной колонке <strong>delete</strong> напротив того элемента, который Вы хотите удалить.</span></td></tr>
	<tr><td class="priority">2</td><td>template_id</td><td>Шаблон элемента.</td></tr>
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


echo '<!-- /Brands Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('categories');

echo '<!-- Categories Tab Start -->';
echo '<!-- /Categories Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('pages');

echo '<!-- Pages Tab Start -->';
echo '<!-- /Pages Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('articles');

echo '<!-- Articles Tab Start -->';
echo '<!-- /Articles Tab End -->';
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('news');

echo '<!-- News Tab Start -->';
echo '<!-- /News Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('customers');

echo '<!-- Customers Tab Start -->';
echo '<!-- /Customers Tab End -->'; 
    
echo $this->Admin->EndTabContent();

echo $this->Admin->StartTabContent('orders');

echo '<!-- Orders Tab Start -->';
echo '<!-- /Orders Tab End -->';
    
echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Admin->ShowPageHeaderEnd();

?>