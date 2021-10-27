<?php

/**
 * @package   Site Integration mod
 * @version   
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

add_integration_function('integrate_pre_include', '$sourcedir/Subs-SiteIntegration.php');
add_integration_function('integrate_admin_include', '$sourcedir/ManageSiteIntegration.php');
add_integration_function('integrate_actions', 'siteintegration_actions');
add_integration_function('integrate_load_theme', 'siteintegration_load_theme');
add_integration_function('integrate_modify_modifications', 'siteintegration_modify_modifications');
add_integration_function('integrate_admin_areas', 'siteintegration_admin_areas');
add_integration_function('integrate_whos_online', 'siteintegration_whos_online');