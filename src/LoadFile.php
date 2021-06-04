<?php

if (!defined('SMF'))
	die('Hacking attempt...');
	
/*
	Site Integration Mod v1.4, made by LHVWB.
	Homepage: http://custom.simplemachines.org/mods/index.php?mod=1146
	
	LoadFile.php - Handles the loading of included actions/files for the Site Integration Mod.
*/	

//	This function basically sets up the file and language includes for the template file.
function LoadFile()
{
	global $context, $mbname, $boarddir, $modSettings, $user_info, $sourcedir, $boardurl;
	
	//	Check permissions before we even load anything.
	if(!allowedTo("SiteIntegration:".$context['current_action']))
	{
		//	If they are a guest then show a login screen.
		if($user_info['is_guest']
		//	Also make sure that the correct setting has been check to enable redirecting of guests to a login screen.
		&& isset($modSettings['SiteIntegrationMod_badpermissions_guestlogin'])
		&& $modSettings['SiteIntegrationMod_badpermissions_guestlogin'])
		{
			//	Show the login page.
			require_once($sourcedir."/LogInOut.php");
			Login();
			//	Set the url so that when the user logs in, they will be redirected back to the correct action.
			$_SESSION['login_url'] = $boardurl . "/index.php?action=".$context['current_action'];
		}
		//	Other wise they are a member and we will send them to the setable permissions error page.
		elseif(isset($modSettings['SiteIntegrationMod_failed_permissions_action']))
			redirectexit("action=".$modSettings['SiteIntegrationMod_failed_permissions_action']);
			
		//	Can't be bothered mucking around with this scumbag, send them straight to the board home.
		else
			redirectexit();
		
		//	Break this function to avoid any annouying errors.
		return false;
	}
	
	$context['language_includes'] = array();

	//	Setup the general language includes array.
	$general_language_includes = array();
	
	if(isset($modSettings['SiteIntegrationMod_general_language_files']))
		foreach(explode(',' , $modSettings['SiteIntegrationMod_general_language_files']) as $language)
		{
			$general_language_includes[] = trim(strtolower($language)).".".$user_info['language'].".php";
		}	

	//	Shall we try to find some language files?
	if(isset($modSettings['SiteIntegrationMod_language_includes_folders']))
	{
		//	Get the list of folders for including language files, all separated by commas.
		$language_folders = explode(',' , $modSettings['SiteIntegrationMod_language_includes_folders']);
		
		//	Cycle through the folders.
		foreach($language_folders as $folder)
		{
			//	Get rid of any nasty whitespace and forward slashes at the end or beginning of the folder name.
			$folder = strtolower(trim($folder, "/ "));
			
			//	Make sure that the folder exists.
			if(file_exists($boarddir."/".$folder."/")
			&& !($folder == '')
			//	Also make sure that no important folders are being passed.
			&& !(in_array(strtolower($folder), array('attachments', 'cache', 'packages', 'smileys', 'sources', 'themes'))))
			{
				//	Store each current language file from the folder, the template can load them!
				foreach(scandir($boarddir."/".$folder."/", 1) as $file)
				{ 
					//	Make sure the file is a (current_language).php file before we include it.
					if(substr($file, -5-strlen($user_info['language'])) == ".".$user_info['language'].".php")
					{
						//	Check that the file is an include specifically for this action. Do here this for clarity sake.
						if((strtolower($file) == strtolower($context['current_action']).".".$user_info['language'].".php")
						//	Or if its a  general language include.
						|| (in_array(strtolower($file), $general_language_includes)))
							//	Finally include the file!!! ;)
							require_once($boarddir."/".$folder."/".$file);
					}
				}
			}
		}
	}
				
	$current_folder = '';

	//	Check through the folders, and get the current actions folder.
	foreach($context['includes_folders'] as $folder)
	{
		//	Check for the current action's file in the file includes folder.
		//	Only ever load the first action found, to make sure we are refering to the same file.
		if(file_exists($boarddir."/".$context['siteintegration_actions'][$context['current_action']][0])
		&& !($current_folder))
		{
			$current_folder = $folder;
		}
	}
	
	//	Set the file include up for the template.
	$context['file_include'] = $boarddir."/".$context['siteintegration_actions'][$context['current_action']][0];
	
	//	Does this action have its own title?
	if(isset($modSettings['SiteIntegration_title:'.$context['current_action']])
	&& ($modSettings['SiteIntegration_title:'.$context['current_action']] != ''))
	{
		//	Do we have a special $txt var for this title?
		if(isset($modSettings['SiteIntegrationMod_language_prefix'])
		&& ($modSettings['SiteIntegrationMod_language_prefix'] != '')
		&& isset($txt[$modSettings['SiteIntegrationMod_language_prefix'].$modSettings['SiteIntegration_title:'.$context['current_action']]]))
			$context['page_title'] = $txt[$modSettings['SiteIntegrationMod_language_prefix'].$modSettings['SiteIntegration_title:'.$context['current_action']]];
		//	Otherwise, just show the stinking title.
		else
			$context['page_title'] = $modSettings['SiteIntegration_title:'.$context['current_action']];	
	}
	//	No sepcial title? Oh well, set a default page title, go with the community name. Just for fun!
	else
		$context['page_title'] = $mbname;	
	
	//	Load the template, it can do the rest!
	loadTemplate('SiteIntegration');
	$context['sub_template'] = 'SiteIntegration';
}

?>