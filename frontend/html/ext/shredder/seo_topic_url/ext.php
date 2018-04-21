<?php

/**
*
* @package SEO Topic URL
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\seo_topic_url;

/**
* Main extension class for this extension.
*/
class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		global $config;

		$version_helper = $this->container->get('version_helper');
		return $version_helper->compare($config['version'], '3.1.6', '>=');
	}
}
