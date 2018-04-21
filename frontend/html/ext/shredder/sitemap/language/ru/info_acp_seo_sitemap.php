<?php

/**
*
* info_acp_seo_sitemap [Russian]
*
* @package phpBB3 SEO Sitemap
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
	'SEOMAP'						=> 'SEO Карта сайта',
	'SEOMAP_VERSION'				=> 'Версия расширения: %s. Новые версии и поддержку вы можете найти <a style="font-weight: bold;" href="http://www.phpbb-work.ru/sitemap-extension-t76.html" onclick="window.open(this.href);return false;">на странице расширения на сайте автора</a>.',
	'SEOMAP_EXPLAIN'				=> 'Обратите внимание, что применение необязательных опций priority (приоритет) и changefreq (частота обновления) может дать некоторый позитивный результат, но рекомендуется использовать их вместе и только после анализа того, какие страницы должны считаться более важными по сравнению с другими, прежде чем принимать какие-либо решения. Если вы не знаете или не уверены, то лучше отключите эти опции. Более подробно о priority и changefreq читайте <a href="http://www.sitemaps.org/ru/protocol.html#xmlTagDefinitions" onclick="window.open(this.href);return false;">здесь</a>.<br />Для отключения приоритета введите 0.',
	'SEOMAP_SETTINGS'				=> 'Настройки SEO Sitemap',
	'SEOMAP_SETTINGS_UPDATED'		=> '<strong>Изменены настройки SEO Sitemap</strong>',
	'SEOMAP_SAVED'					=> 'Настройки SEO Sitemap успешно изменены.',
	'SEOMAP_EXCLUDED'				=> 'Исключённые форумы',
	'SEOMAP_EXCLUDED_EXPLAIN'		=> 'Выбранные здесь форумы и темы из них не будут внесены в карту сайта для ботов.<br /><strong>Внимание:</strong> Категории и форумы без тем исключены из карты по умолчанию.',
	'SEOMAP_CACHE_TIME'				=> 'Время хранения в кеше',
	'SEOMAP_CACHE_TIME_EXPLAIN'		=> 'Для уменьшения нагрузки на сервер созданная карта сайта кешируется на некоторое время. По истечении этого времени она будет создана заново. Укажите здесь время в часах, на которое карта будет сохранена в кеше или введите 0 для отключения кеширования.',
	'SEOMAP_URL'					=> 'Ссылка на карту: <a href="%s" onclick="window.open(this.href);return false;">%s</a>',
	'SEOMAP_URL_COUNT'				=> 'Общее число URL в карте: %s',
	'SEOMAP_URL_LIMIT'				=> 'Лимит URL',
	'SEOMAP_URL_LIMIT_EXPLAIN'		=> 'Максимальное число URL в одном файле карты, не более 50000 по стандарту sitemap. Поставьте меньше, если испытываете проблемы с превышением лимитов. Если количество URL в карте сайта превысит заданное здесь число, она будет автоматически разбита на несколько файлов.',
	'SEOMAP_BATCH_SIZE'				=> 'Предпочтительный размер пакета обработки',
	'SEOMAP_BATCH_SIZE_EXPLAIN'		=> 'Уменьшите размер пакета обработки, если происходят ошибки нехватки памяти PHP во время генерации карты. Обратите внимание, что время генерации карты будет значительно возрастать при каждом уменьшении размера пакета обработки.',
	'SEOMAP_PRIORITY_0'				=> 'Приоритет для обычных тем',
	'SEOMAP_PRIORITY_1'				=> 'Приоритет для прикрепленных тем',
	'SEOMAP_PRIORITY_2'				=> 'Приоритет для объявлений',
	'SEOMAP_PRIORITY_3'				=> 'Приоритет для "важных" тем',
	'SEOMAP_PRIORITY_4'				=> 'Приоритет для тем-статей',
	'SEOMAP_PRIORITY_F'				=> 'Приоритет для форумов',
	'SEOMAP_FREQ_0'					=> 'Частота обновления обычных тем',
	'SEOMAP_FREQ_1'					=> 'Частота обновления прикрепленных тем',
	'SEOMAP_FREQ_2'					=> 'Частота обновления объявлений',
	'SEOMAP_FREQ_3'					=> 'Частота обновления "важных" тем',
	'SEOMAP_FREQ_4'					=> 'Частота обновления тем-статей',
	'SEOMAP_FREQ_F'					=> 'Частота обновления форумов',
	'SEOMAP_FREQ_NEVER'				=> 'Никогда',
	'SEOMAP_FREQ_YEARLY'			=> 'Ежегодно',
	'SEOMAP_FREQ_MONTHLY'			=> 'Ежемесячно',
	'SEOMAP_FREQ_WEEKLY'			=> 'Еженедельно',
	'SEOMAP_FREQ_DAILY'				=> 'Ежедневно',
	'SEOMAP_FREQ_HOURLY'			=> 'Ежечасно',
	'SEOMAP_FREQ_ALWAYS'			=> 'Постоянно',
	'SEOMAP_NO_DATA'				=> 'Нет данных для внесения в карту.',
	'SEOMAP_NO_FILE'				=> 'Невозможно открыть файл:<br /><strong>%s</strong>',
	'SEOMAP_CANT_WRITE'				=> 'Папка <strong>%s</strong> не существует или недоступна для записи. Исправьте это вручную, используя FTP-клиент.',
	'SEOMAP_COPYRIGHT'				=> 'Моды и расширения phpBB',

// Sync section
	'SEOMAP_SYNC_COMPLETE' 			=> 'Синхронизация дат успешно завершена.<br /><br /><a style="font-weight: bold;" href="%s">&laquo; Вернуться к настройкам</a>',
	'SEOMAP_SYNC_PROCESS'			=> '<strong>Идёт синхронизация. Не закрывайте страницу и не прерывайте скрипт до завершения его работы.</strong><br /><br />Закончена обработка <strong>%1$s%%</strong>. Обработано <strong>%2$s</strong> сообщений. Всего сообщений: <strong>%3$s</strong>.',
	'SEOMAP_SYNC_REQ' 				=> 'Вы должны синхронизировать даты изменения сообщений перед началом использования карты. Это необходимо для генерации времени последней модификации страниц в карте. <a style="font-weight: bold;" href="%s">Перейти к синхронизации</a>.',
));
