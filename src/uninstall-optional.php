<?php

/**
 * @package   Site Integration mod
 * @version   2.0.1
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

$smcFunc['db_query'](
	'',
	'
	DELETE FROM {db_prefix}settings
	WHERE setting
	LIKE {string:fuzzy_settings}',
	array(
		'fuzzy_settings' => 'siteintegration_title%',
	)
);

$smcFunc['db_query'](
	'',
	'
	DELETE FROM {db_prefix}permissions
	WHERE permission
	LIKE {string:fuzzy_permissions}',
	array(
		'fuzzy_permissions' => 'siteintegration%',
	)
);