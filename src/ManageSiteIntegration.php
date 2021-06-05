<?php

/**
 * @package   Site Integration mod
 * @version   2.0.0
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

//	Handle Site Integration Settings.
function ModifySiteIntegrationSettings($return_config = false)
{
	global $txt, $scripturl, $context, $sourcedir;

	// Managing the settings for a particular action/file include?
	if (isset($_GET['integration_action'], $context['siteintegration_actions'][$_GET['integration_action']]))
	{
		$invalid = preg_match('/[^a-zA-Z0-9-]/', $_GET['integration_action']);
		$config_vars = [
			[
				'text',
				'siteintegration_title:' . $_GET['integration_action'],
				'label' => $txt['siteintegration_include_title'],
				'help' => 'siteintegration_include_title',
				'disabled' => $invalid,
			],
			[
				'permissions',
				'siteintegration:' . $_GET['integration_action'],
				'label' => $txt['siteintegration_include_permissions'],
				'help' => 'siteintegration_include_permissions',
				'disabled' => $invalid,
			],
			[
				'check',
				'siteintegration_who:' . $_GET['integration_action'],
				'label' => $txt['siteintegration_show_whosonline'],
				'help' => 'siteintegration_show_whosonline',
				'disabled' => $invalid,
			],
		];
		$context['post_url'] = sprintf(
			'%s?action=admin;area=modsettings;save;sa=siteintegration;integration_action=%s',
			$scripturl,
			$_GET['integration_action']
		);
		$context['settings_title'] = sprintf(
			'%s - %s: "%s"',
			$txt['siteintegration_tab_heading'],
			$txt['siteintegration_manage_include'],
			$_GET['integration_action']
		);
		$context['settings_message'] = sprintf(
			'<a href="%s?action=admin;area=modsettings;save;sa=siteintegration">%s</a>',
			$scripturl,
			$txt['siteintegration_back']
		);
		if ($invalid)
		{
			$context['settings_insert_above'] = sprintf(
				'<div class="errorbox">%s<ul><li>%s</li><li>%s</li></ul></div>',
				$txt['siteintegration_character_warning'],
				sprintf(
					$txt['siteintegration_current_filename'],
					'<code>' . $_GET['integration_action'] . '</code>'
				),
				sprintf(
					$txt['siteintegration_suggested_filename'],
					'<code>' . trim(preg_replace('/[^a-zA-Z-]/', '-', $_GET['integration_action']), '-') . '</code>'
				)
			);
			$context['settings_save_dont_show'] = true;
		}
	}
	//	Wipe any unnessesary include management settings from the table/cache?
	elseif (isset($_GET['clean_include_cache']))
	{
		clean_siteintegration_include_cache();
		redirectexit('action=admin;area=modsettings;sa=siteintegration');
	}
	else
	{
		$config_vars = [
			['text', 'siteintegration_includes_folders'],
			['text', 'siteintegration_site_error_page'],
			['text', 'siteintegration_site_home_action'],
			['text', 'siteintegration_general_language_files'],
		];

		if ($return_config)
			return $config_vars;

		//	Setup the list display area.
		$listActions = [
			'id' => 'siteintegration_list',
			'items_per_page' => 10,
			'default_sort_col' => 'include',
			'title' => $txt['siteintegration_manage_include'],
			'base_href' => $scripturl . '?action=admin;area=modsettings;sa=siteintegration',
			'no_items_label' => $txt['siteintegration_no_includes'],
			'get_items' => [
				'function' => 'get_siteintegration_IncludeSettings',
			],
			'get_count' => [
				'function' => function ()
				{
					return count($context['siteintegration_actions']??[]);
				},
			],
			'columns' => [
				'include' => [
					'header' => [
						'value' => $txt['siteintegration_include'],
					],
					'data' => [
						'sprintf' => [
							'format' => '<a href="' . $scripturl . '?action=%s">%1$s</a>',
							'params' => [
								'action' => false,
							],
						],
					],
					'sort' => [
						'default' => 'action',
						'reverse' => 'raction',
					],
				],
				'location' => [
					'header' => [
						'value' => $txt['siteintegration_location'],
					],
					'data' => [
						'db' => 'location',
					],
					'sort' => [
						'default' => 'location',
						'reverse' => 'rlocation',
					],
				],
				'page_title' => [
					'header' => [
						'value' => $txt['siteintegration_page_title'],
					],
					'data' => [
						'db' => 'page_title',
					],
				],
				'manage' => [
					'data' => [
						'sprintf' => [
							'format' => '<a href="' . $scripturl . '?action=admin;area=modsettings;sa=siteintegration;integration_action=%s">' . $txt['siteintegration_manage'] . '</a>',
							'params' => [
								'action' => false,
							],
						],
					],
				],
			],
		];

		require_once($sourcedir . '/Subs-List.php');
		createList($listActions);

		$context['post_url'] = $scripturl . '?action=admin;area=modsettings;save;sa=siteintegration;';
		$context['settings_title'] = $txt['siteintegration_tab_heading'];
		$context['settings_message'] = sprintf(
			'<a href="%s?action=admin;area=modsettings;save;sa=siteintegration;clean_include_cache">%s</a>&mdash;%s',
			$scripturl,
			$txt['siteintegration_clean_cache'],
			$txt['siteintegration_clean_cache_explanation']
		);
		$context['sub_template'] = 'SiteIntegrationSettings';
		loadTemplate('SiteIntegration');
	}
	// Saving?
	if (isset($_GET['save']))
	{
		//	Check that we aren't passing some really annouying post variables.
		if (!isset($_GET['integration_action']) || preg_match('/[a-zA-Z0-9-]/', $_GET['integration_action']))
		{
			//	Check that this user can edit this area.
			checkSession();
			//	Save any normal settings.
			saveDBSettings($config_vars);
		}
		//	Finally take use away!
		redirectexit('action=admin;area=modsettings;sa=siteintegration');
	}

	//	Prepare the settings to be stored in the database and shown by the settings page.
	prepareDBSettingContext($config_vars);
}

//	Get all of the Include Settings from the database.
function get_siteintegration_IncludeSettings($start, $items_per_page, $sort)
{
	global $boarddir, $context, $modSettings, $mbname;

	$list = [];
	foreach ($context['siteintegration_actions'] as $action => $data)
		$list[] = [
			'action' => $action,
			'location' => strtr(strtr($data, '\\', '/'), array(strtr($boarddir, '\\', '/') => '.')),
			'page_title' => siteintegration_get_page_title($action),
		];

	$tmp = [];
	foreach ($list as $key => $row)
		$tmp[$key] = $row[$sort];

	array_multisort($tmp, $sort[0] == 'r' ? SORT_DESC : SORT_ASC, $list);

	if ($items_per_page)
		$list = array_slice($list, $start, $items_per_page);

	return $list;
}

//	This function is used to clean the permissions and settings tables
//	by deleting any data which no longer has an included action.
//	This data could be there because the include was renamed, moved or etc.
function clean_siteintegration_include_cache()
{
	global $smcFunc;

	$smcFunc['db_query'](
		'',
		'
	DELETE FROM {db_prefix}settings
	WHERE setting
	LIKE {string:fuzzy_settings}',
		[
			'fuzzy_settings' => 'siteintegration_title%',
		]
	);

	$smcFunc['db_query'](
		'',
		'
	DELETE FROM {db_prefix}permissions
	WHERE permission
	LIKE {string:fuzzy_permissions}',
		[
			'fuzzy_permissions' => 'siteintegration%',
		]
	);
}
