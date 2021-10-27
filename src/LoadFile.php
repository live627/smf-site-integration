<?php

/**
 * @package   Site Integration mod
 * @version   
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

function LandingPage()
{
	global $modSettings;

	siteintegration_load_file($modSettings['siteintegration_site_home_action']);
}

function LoadFile()
{
	global $context, $scripturl;

	$action = $context['current_action'];
	isAllowedTo('siteintegration:' . $action);
	siteintegration_load_file($action);
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=' . $action,
		'name' => $context['page_title'],
	);
}

function siteintegration_load_file(string $action)
{
	global $context, $settings;

	loadTemplate('SiteIntegration');
	$context['sub_template'] = 'SiteIntegration';
	$context['page_title'] = siteintegration_get_page_title($action);

	siteintegration_get_language_includes_for_action($action);
	ob_start();
	require $context['siteintegration_actions'][$action];
	$code = ob_get_contents();
	ob_end_clean();
	$context['page_contents'] = $code;
}

function siteintegration_get_language_includes_for_action(string $action)
{
	global $context, $modSettings, $settings;

	// Hax0rz!! Try to hack the language.
	// Make hacking great again.
	$theme_dir = $settings['theme_dir'];
	$settings['theme_dir'] = dirname($context['siteintegration_actions'][$action]);

	$language_includes = [$action];
	if (isset($modSettings['siteintegration_general_language_files']))
		foreach (explode(',', $modSettings['siteintegration_general_language_files']) as $language)
			$language_includes[] = trim($language);

	loadLanguage(implode('+', $language_includes), '', false);

	// Restore theme dir. I'm so polite.
	$settings['theme_dir'] = $theme_dir;
}