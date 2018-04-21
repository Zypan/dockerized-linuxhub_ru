<?php

/**
*
* @package SEO Topic URL
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\seo_topic_url\migrations;

class v_1_0_10 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['stc_version']) && version_compare($this->config['stc_version'], '1.0.10', '>=');
	}

	static public function depends_on()
	{
		return array('\shredder\seo_topic_url\migrations\v_1_0_9');
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.update', array('stc_version', '1.0.10')),
		);
	}
}
