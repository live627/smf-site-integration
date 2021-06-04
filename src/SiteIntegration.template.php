<?php

/*
	Site Integration Mod v1.4, made by LHVWB.
	Homepage: http://custom.simplemachines.org/mods/index.php?mod=1146
	
	SiteIntegration.template.php - Handles the including of the files into the template and any extra language files.
*/

//	Load the generic include page template. It isn't much but its important!
function template_SiteIntegration()
{
	global $context;
		//	Show a display box for the included page.
	echo'
	<div class="tborder" style="margin-top: 1ex;">
		<div style="padding: 2ex;" id="helpmain">
		';

		//	Include the page.
		require_once($context['file_include']);
		
	//	End the display box.
	echo '
		</div>
	</div>
	';
}

//	 Basically just puts together two types of sub templates for the SiteIntegration Settings section.
function template_SiteIntegrationSettings()
{
	template_show_settings();
	echo('<br /><br />');
	template_SiteIntegration_list();
}

function template_SiteIntegration_list()
{
	global $context;
	
	$list = $context['SiteIntegration_List'];
	
	//	Start the lists table and the title.
	echo '
			<table border="0" width="100%" cellspacing="1" cellpadding="4" class="bordercolor" align="center">
				<tr class="catbg">
					<td colspan="', $list['num_columns'], '">', $list['title'], '</td>
				</tr>';
	
	//	Make sure that there is some data before we show the actual table.
	if(!empty($list['row_data']))
	{
		echo '
				<tr>';
				
		//	Show the column titles/headers.
		foreach($list['column_headers'] as $name => $header)
			echo '
					<th valign="top" class="titlebg"/>', $header ,'</th>';		
			
		echo'
				</tr>';
		
		//	Show the actual rows of data.
		foreach($list['row_data'] as $row)
		{
			echo '
				<tr>';
			
			foreach($row as $field)
				echo ' 
					<td class="windowbg2">',$field,'</td>';
			
			echo '
				</tr>';
		}
	}
	//	Show a 'no data' message, if there is not data.
	else
		echo '
				<tr> 
					<td class="windowbg" colspan="', $list['num_columns'], '" align=center>', $list['no_items_label'] ,'</td>
				</tr>';
	
	//	Finish off the table.
	echo '
			</table>';
}

?>