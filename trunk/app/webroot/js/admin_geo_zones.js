function onCreateNew()
{
	if (0 == $('#country-zones-dialog').length) {
		countryZoneSelection();
	} else {
		$('#country-zones-dialog').dialog();
	}
}

function countryZoneSelection()
{
	return $('<div id="country-zones-dialog"></div>').load('/geo_zones/admin_country_zones/').dialog({
		modal: true,
		title: i18n.CountryZones,
		height: 200,
		width: 410,
		buttons: [{
			text: i18n.Select,
			click: function() {
				var country_id = $("#GeoZoneZonesGeoZoneId").val();
				var region_id = $("select#country_zones").val();
				if ('' == country_id || '' == region_id) {
					alert(i18n.SelectRegion);
				} else {
					$.get("/geo_zones/admin_country_zone_link/" + country_id + "/" + region_id, {}, function() {
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
	var country_id = '';
	country_id = $("select#countries").val();
	$.get("/geo_zones/admin_country_zones_getzones/" + country_id, {}, function(data){
		$("select#country_zones").replaceWith(data);
	});
}