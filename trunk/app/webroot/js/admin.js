
	$(document).ready(function(){

		$("select#ContentContentTypeId").change(function () {
			$("div#content_type_fields").load("/contents/admin_edit_type/"+$("select#ContentContentTypeId").val());
		})

		$("select#TaxCountryZoneRateCountryId").change(function () {
			$("div#zones_by_country").load("/tax_country_zone_rates/list_zones_by_country/"+$("select#TaxCountryZoneRateCountryId").val());
		})

	});

	$(function(){
		$('#tabs').tabs();
	});

		function selectall()
		{
	        checkboxes = document.getElementsByTagName("input");
	        for (i=0; i<checkboxes.length ; i++)
	        {
	                if (checkboxes[i].type == "checkbox") checkboxes[i].checked=true;
	        }
		}
