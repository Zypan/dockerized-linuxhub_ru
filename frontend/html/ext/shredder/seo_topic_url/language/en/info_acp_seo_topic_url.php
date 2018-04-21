<?php

/**
*
* info_acp_seo_topic_url [English]
*
* @package SEO Topic URL
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'STC_ACP_LEGEND'				=> 'Advanced Settings',
	'STC_ACP_MODE'					=> 'Optimization mode',
	'STC_ACP_MODE_EXPLAIN'			=> 'SEO Topic & Canonical URL extension settings.',
	'STC_ACP_OPTION_0'				=> 'Remove forum ID in Topic URL',
	'STC_ACP_OPTION_1'				=> 'Add forum ID to Canonical URL',
	'STC_ACP_OPTION_2'				=> 'Remove Canonical URL in topics',
));
