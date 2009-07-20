
	$(document).ready(function(){
		$("select#ContentContentTypeId").change(function () {
			$("div#content_type_fields").load("/contents/admin_edit_type/"+$("select#ContentContentTypeId").val());
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
