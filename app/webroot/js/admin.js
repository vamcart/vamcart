		function set_active_tab_content (tab)
		{
			// Hide all sections
			var sections = document.getElementsByClassName('tab_content');
			for(var j=0; j<sections.length; j++)
			{
				$(sections[j].id).style.display = 'none';

			}
			// Display the section that we want to
			$('tab_content_' + tab).style.display = 'block';
		}
		
		function set_active_tab_header (tab) 
		{
			var sections = document.getElementsByClassName('active');
			for(var j=0; j<sections.length; j++)
			{
				$(sections[j].id).className = 'tab';
			}
			$('tab_' + tab).className = 'active';
		}
		
		function set_active_tab (tab)
		{
			set_active_tab_content(tab);
			set_active_tab_header(tab);			
		}
		
		function hide_tabs()
		{
			set_active_tab('main');
		}

		function selectall()
		{
	        checkboxes = document.getElementsByTagName("input");
	        for (i=0; i<checkboxes.length ; i++)
	        {
	                if (checkboxes[i].type == "checkbox") checkboxes[i].checked=true;
	        }
		}
