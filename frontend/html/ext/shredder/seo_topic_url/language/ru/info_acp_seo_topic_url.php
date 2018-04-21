<?php

/**
*
* info_acp_seo_topic_url [Russian]
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
	'STC_ACP_LEGEND'				=> 'Дополнительные настройки',
	'STC_ACP_MODE'					=> 'Способ оптимизации',
	'STC_ACP_MODE_EXPLAIN'			=> 'Настройки расширения SEO Topic & Canonical URL.',
	'STC_ACP_OPTION_0'				=> 'Удалить ID форума из URL тем',
	'STC_ACP_OPTION_1'				=> 'Добавить ID форума к тегу Canonical',
	'STC_ACP_OPTION_2'				=> 'Удалить тег Canonical в темах',
));
