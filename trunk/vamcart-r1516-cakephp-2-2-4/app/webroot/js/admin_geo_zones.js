function onCreateNew()
{
    if (0 == $('#country-zones-dialog').length) {
        countryZoneSelection();

    } else {
        $('#country-zones-dialog').dialog();
    }
}

function onDialogLoaded()
{
    $("#country_zones").attr("multiple", "multiple");
    $("#country_zones").addClass("multiselect");
    $(".multiselect").multiSelect();

    $('#selectAll').click(function(){
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
    return $('<div id="country-zones-dialog"></div>').load('/geo_zones/admin_country_zones/', onDialogLoaded).dialog({
        modal: true,
        title: i18n.CountryZones,
        height: 410,
        width: 440,
        buttons: [{
            text: i18n.Select,
            click: function() {
                var geo_zone_id = $("#GeoZoneZonesGeoZoneId").val();
                var country_zones_id = $("select#country_zones").val();
                if ('' == geo_zone_id || '' == country_zones_id) {
                    alert(i18n.SelectRegion);
                } else {
                    $.post("/geo_zones/admin_country_zone_link/", {
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
                $(this).dialog('close');
            }
        }]
    });
}

function onCountriesChanged()
{
    $("#ms-country_zones").remove();
    var country_id = '';
    country_id = $("select#countries").val();
    $.get("/geo_zones/admin_country_zones_getzones/" + country_id, {}, function(data){
        $("select#country_zones").replaceWith(data);
        $("#country_zones").attr("multiple", "multiple");
        $("#country_zones").addClass("multiselect");
        $(".multiselect").multiSelect();
    });
}