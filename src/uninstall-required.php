<?php

/**
 * @package   Site Integration mod
 * @version   2.0.1
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

remove_integration_function('integrate_pre_include', '$sourcedir/Subs-SiteIntegration.php');
remove_integration_function('integrate_admin_include', '$sourcedir/ManageSiteIntegration.php');
remove_integration_function('integrate_actions', 'siteintegration_actions');
remove_integration_function('integrate_load_theme', 'siteintegration_load_theme');
remove_integration_function('integrate_modify_modifications', 'siteintegration_modify_modifications');
remove_integration_function('integrate_admin_areas', 'siteintegration_admin_areas');
remove_integration_function('integrate_whos_online', 'siteintegration_whos_online');