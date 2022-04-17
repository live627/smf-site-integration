<?php

/**
 * @package   Site Integration mod
 * @version   2.0.1
 * @author    John Rayes <live627@gmail.com>
 * @copyright Copyright (c) 2021, John Rayes
 * @license   http://opensource.org/licenses/MIT MIT
 */

function template_SiteIntegration()
{
	global $context;

	echo '
	<div class="cat_bar">
		<h3 class="catbg">
			', $context['page_title'], '
		</h3>
	</div>
	<span class="upperframe"><span></span></span>
	<div class="roundframe">
		', $context['page_contents'], '
	</div>
	<span class="lowerframe"><span></span></span>';
}

function template_SiteIntegrationSettings()
{
	template_show_settings();
	echo '<br /><br />';
	template_show_list('siteintegration_list');
}