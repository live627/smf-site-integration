<?php

/**
 * @package   Site Integration mod
 * @version   
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

global $helptxt;

//	Site Integration Settings Text.
$txt['siteintegration_includes_folders'] = 'File/Action Include Folders';
$txt['siteintegration_general_language_files'] = 'Site-Wide Language Integration Files';
$txt['siteintegration_include_permissions'] = 'Permissions';
$txt['siteintegration_include_title'] = 'Title';
$txt['siteintegration_site_error_page'] = 'Invalid Action Error Action';
$txt['siteintegration_site_home_action'] = 'Forum Default/Home Action';
$txt['siteintegration_show_whosonline'] = 'Show in Whosonline list?';

//	Site Integration Settings Misc text that doesn't belong to a direct setting.
//	General Settings area.
$txt['siteintegration_tab_heading'] = 'Site Integration';
$txt['siteintegration_clean_cache'] = 'Clean the File/Action Include Management Cache';
$txt['siteintegration_clean_cache_explanation'] = 'This will clear any old include management settings and permissions which could be leftover when you move or rename files.';
$txt['siteintegration_back'] = 'Back To General Settings';
$txt['siteintegration_character_warning'] = 'The name of this file/action include contains some illegal characters.';
$txt['siteintegration_current_filename'] = 'Your filename is %s';
$txt['siteintegration_suggested_filename'] = 'Suggested filename is %s';

//	List Settings area.
$txt['siteintegration_manage_include'] = 'Manage Included Files/Actions';
$txt['siteintegration_include'] = 'File/Action Include';
$txt['siteintegration_location'] = 'File Location';
$txt['siteintegration_page_title'] = 'Page Title';
$txt['siteintegration_manage'] = 'Manage';
$txt['siteintegration_no_includes'] = 'You currently have no included actions/files.';

// argument(s): $scripturl, $action
$txt['siteintegration_who'] = 'Viewing <a href="%s?action=%s">%s</a>.';

//	Help for the Site Integration Mod Settings.
$helptxt['siteintegration_includes_folders'] = 'This setting allows you to add multiple folders, by separating them with commas. All of the .php files in those folders will be turned into actions by SMF.<br/><br/>Please Note that the folder names are relative to the SMF home directory. (eg. \'file_includes\' will load actions from \'(SMF Home Directory)/file_includes/\')<br/><br/>Also Note that it doesn\'t matter if you use forward slashes at the beginning or end of the folder names, they are however nessesary in the middle if you are trying to load a subfolder (eg. \'file_includes/files\').';
$helptxt['siteintegration_general_language_files'] = 'If your site only uses one language then ignore this option. <br /><br />This setting allows you to add a series of general site-wide language includes, separated by commas. When the system searches through your language include folders (refer to above setting), it will always include language files which have this prefix, no matter which action you are viewing.<br /><br /> For example, when the language is french-utf8 and the action is demo, but you have set a general language include called \'sitelanguage\', it will look for and include \'demo.french-utf8.php\' and \'sitelanguage.french-utf8.php\'. <br /><br /> Setting variables and using them works exactly the same for these site-wide language includes, as for the language includes discussed in the previous settings help pop-up.';
$helptxt['siteintegration_include_permissions'] = 'This setting allows you to restrict who can view this included action/file. By default only Admin can view included files/actions.';
$helptxt['siteintegration_include_title'] = 'This setting allows you to create a custom title for the current action/file include. This title will be shown as the page title when this action is view. By default the boards name will be shown as the title.';
$helptxt['siteintegration_site_error_page'] = 'This setting allows you to change the action/page which will be shown when you try to view an action which doesn\'t exsist within the SMF system. If this setting is empty then the "Forum Default/Home Action" will be shown for all invalid actions. Please remember that this MUST be an action, it can however be any action from the entire SMF forum system.';
$helptxt['siteintegration_site_home_action'] = 'This setting allows you to change the default action/page which is shown when you view "index.php", without any specified action. If the "Invalid Action Error Action" field is empty or invalid then this action will also be shown if the action is invalid. Please note that if you use this setting, you will still be able to access the default forums index, from the \'forum\' action at "index.php?action=forums". Please also remember that this MUST be an action, it can however be any action from the entire SMF forum system.';
$helptxt['siteintegration_show_whosonline'] = 'This setting allows you to chose whether or not this action will be shown in the whosonline list, if checked the "action" in the list for a user viewing an included file/action will be the same as the titles text, otherwise it will be shown as generic message like \'Unknown Action\'. Remember that only users with permissions to actually view the page will be able to see other users viewing it, otherwise they will get the generic message as well.';
