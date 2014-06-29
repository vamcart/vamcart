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

$fname = 'admin_geo_zones_i18n_' . $l . '.js';

if (!file_exists(WWW_ROOT . 'js/' . $fname)) {
	$fname = 'admin_geo_zones_i18n_en.js';
}

$this->Html->script(array(
    'jquery/plugins/jquery-ui-min.js',
    'lou-multi-select/jquery.multi-select.js',
    'lou-multi-select/jquery.quicksearch.js',
    'selectall.js',
    $fname
), array('inline' => false));
?>
<?php echo $this->Html->scriptBlock('
function onCreateNew()
{
    if (0 == $(\'#country-zones-dialog\').length) {
        countryZoneSelection();

    } else {
        $(\'#country-zones-dialog\').dialog();
    }
}

function onDialogLoaded()
{
    $("#country_zones").attr("multiple", "multiple");
    $("#country_zones").addClass("multiselect");
    $(".multiselect").multiSelect();

    $(\'#selectAll\').click(function(){
        $("#country_zones").multiSelect("select_all");
        return false;
    });

    $("#deselectAll").click(function(){
        $("#country_zones").multiSelect("deselect_all");
        return false;
    });
}

function countryZoneSelection()
{
    return $(\'<div id="country-zones-dialog"></div>\').load(\''. BASE . '/geo_zones/admin_country_zones/\', onDialogLoaded).dialog({
        modal: true,
        title: i18n.CountryZones,
        height: 410,
        width: 440,
        buttons: [{
            text: i18n.Select,
            click: function() {
                var geo_zone_id = $("#GeoZoneZonesGeoZoneId").val();
                var country_zones_id = $("select#country_zones").val();
                if (\'\' == geo_zone_id || \'\' == country_zones_id) {
                    alert(i18n.SelectRegion);
                } else {
                    $.post("'. BASE . '/geo_zones/admin_country_zone_link/", {
                        geo_zone_id: geo_zone_id,
                        country_zones_id: [country_zones_id]
                    }, function() {
                        location.reload();
                    });
                }
            }
        },{
            text: i18n.Cancel,
            click: function() {
                $(this).dialog(\'close\');
            }
        }]
    });
}

function onCountriesChanged()
{
    $("#ms-country_zones").remove();
    var country_id = \'\';
    country_id = $("select#countries").val();
    $.get("'. BASE . '/geo_zones/admin_country_zones_getzones/" + country_id, {}, function(data){
        $("select#country_zones").replaceWith(data);
        $("#country_zones").attr("multiple", "multiple");
        $("#country_zones").addClass("multiselect");
        $(".multiselect").multiSelect();
    });
}
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php
echo $this->Html->css('jquery-ui.css', null, array('inline' => false));
echo $this->Html->css('multi-select.css', null, array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-page-white-world');
echo $this->Form->create('GeoZoneZones', array('action' => '/geo_zones/admin_modify_country_zones_selected/', 'url' => '/geo_zones/admin_modify_country_zones_selected/'));
echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Code'), __('Name'), __('Country'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data['CountryZone'] as $country_zone)
{
	echo $this->Admin->TableCells(
		array($country_zone['code'],
			array($country_zone['name'], array('align' => 'left', 'width' => '50%')),
			array($country_zone['country_name'], array('align' => 'left')),
			array($this->Admin->ActionButton('delete','/geo_zones/admin_country_zone_unlink/' . $country_zone['id'] . '/' . $country_zone['geo_zone_id'], __('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $country_zone['id'])), array('align'=>'center'))
		)
	);
}

echo '</table>';

echo '<table class="contentFooter">';
echo '<tr><td>';
echo $this->Admin->formButton(__('Create New'), 'cus-add', array('class' => 'btn', 'type' => 'button', 'name' => 'addbutton', 'onclick' => 'onCreateNew()'));
echo $this->Admin->formButton(__('Back'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
echo $this->Form->hidden('geo_zone_id', array('value' => $geo_zone_id));
echo '</td>';
echo '<td>';
echo $this->Admin->ActionBar(array('delete'=>__('Delete')), false);
echo $this->Form->end();
echo '</td></tr>';
echo '</table>';

echo $this->Admin->ShowPageHeaderEnd(); 
?>