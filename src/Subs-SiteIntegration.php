<?php

/**
 * @package   Site Integration mod
 * @version   2.0.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

declare(strict_types = 1);

function siteintegration_actions(array &$action_array)
{
	global $boarddir, $context, $modSettings;

	$action_array['forum'] = ['BoardIndex.php', 'BoardIndex'];
	$context['siteintegration_actions'] = [];
	$context['includes_folders'] = [];

	//	First check for the actual folder includes setting, to avoid errors.
	if (isset($modSettings['siteintegration_includes_folders']))
	{
		//	Get the list of folders for including files, all separated by commas.
		$folders = explode(',', $modSettings['siteintegration_includes_folders']);

		foreach ($folders as $folder)
		{
			//	Get rid of any nasty whitespace and forward slashes at the end or beginning of the folder name.
			$folder = trim($folder, '/ ');

			if (!in_array(strtolower($folder), ['attachments', 'cache', 'packages', 'smileys', 'sources', 'themes']))
			{
				foreach (glob($boarddir . '/' . $folder . '/[a-Z].php') as $file)
					if ($file !== "index.php")
					{
						//	Remove the type extension from the file name.
						$action = strtok(basename($file), '.');

						//	Check for an action with the same name.
						// 	This stops dodgy unwashed admin from overriding SMF actions, or defining their own actions multiple times.
						if (!isset($action_array[$action]))
						{
							//	Store the action into the SMF action array.
							$action_array[$action] = ['LoadFile.php', 'LoadFile'];
							//	Add the action into an array for possible later use.
							$context['siteintegration_actions'][$action] = $file;
						}
					}

				$context['includes_folders'][] = $folder;
			}
		}
	}
}

function siteintegration_load_theme()
{
	global $context, $modSettings, $scripturl, $txt;

	if ($context['current_action'] == 'who')
	{
		siteintegration_get_all_language_includes();
		foreach ($context['siteintegration_actions'] as $action => $data)
			if (!isset($txt['whoallow_' . $action]))
			{
				$txt['whoallow_' . $action] = sprintf(
					$txt['siteintegration_who'],
					$scripturl,
					$action,
					siteintegration_get_page_title($action)
				);

				//	Add the permisions for this action.
				$allowedActions[$action] = ['siteintegration:' . $action];
			}
	}

	if ($context['current_action'] == 'helpadmin')
		loadLanguage('SiteIntegration');
}

function siteintegration_whos_online(array $actions)
{
	global $txt;

	if (isset($txt['whoallow_' . $actions['action']]) && allowedTo('siteintegration:' . $actions['action']))
		return $txt['whoallow_' . $actions['action']];

	return $txt['who_hidden'];
}

function siteintegration_admin_areas(array &$admin_areas)
{
	global $txt;

	loadLanguage('SiteIntegration');
	$admin_areas['config']['areas']['modsettings']['subsections']['siteintegration'] = [$txt['siteintegration_tab_heading']];
}

function siteintegration_modify_modifications(array &$sub_actions)
{
	$sub_actions['siteintegration'] = 'ModifySiteIntegrationSettings';
}

function siteintegration_get_page_title(string $action) : string
{
	global $mbname, $modSettings;

	if (!empty($modSettings['siteintegration_title:' . $action]))
		return $txt['title_' . $action] ?? $modSettings['siteintegration_title:' . $action];

	return $mbname;
}

function siteintegration_get_all_language_includes()
{
	global $context, $modSettings, $settings;

	$language_includes = array_keys($context['siteintegration_actions'];
	if (isset($modSettings['siteintegration_general_language_files']))
		foreach (explode(',', $modSettings['siteintegration_general_language_files']) as $language)
			$language_includes[] = trim($language);

	foreach ($context['includes_folders'] as $folder)
	{
		$theme_dir = $settings['theme_dir'];
		$settings['theme_dir'] = $folder;

		loadLanguage(implode('+', $language_includes), '', false);

		// Restore theme dir. I'm so polite.
		$settings['theme_dir'] = $theme_dir;
	}
}