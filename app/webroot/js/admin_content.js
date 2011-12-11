function beforeSubmit(form)
{
	var action = form.multiaction.value;

	$('#categories-dialog').dialog('destroy');

	if ('copy' == action) {
		var dialog = categorySelection(form);
		return false;
	} else if ('move' == action) {
		var dialog = categorySelection(form);
		return false;
	} else {
		return true;
	}
}

function categorySelection(form)
{
	return $('<div id="categories-dialog"></div>').load('/contents/admin_categories_tree/').dialog({
		modal: true,
		title: 'Categories',
		height: 200,
		buttons: {
			"Select": function () {
				var val = $("#category").val();
				$(form).append('<input type="hidden" name="target_category" />');
				$("input[name=target_category]").val(val);
				$(form).submit();
				$(this).dialog("close");
			},
			"Cancel": function () {
				$(this).dialog("close");
			}
		},
		close: function () {
			$("#category").val('');
		}
	});
}
