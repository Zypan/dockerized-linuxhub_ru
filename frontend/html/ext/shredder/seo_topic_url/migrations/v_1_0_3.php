<?php

/**
*
* @package SEO Topic URL
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\seo_topic_url\migrations;

class v_1_0_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['stc_version']) && version_compare($this->config['stc_version'], '1.0.3', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('stc_mode', 0)),

			// Current version
			array('config.add', array('stc_version', '1.0.3')),
		);
	}
}
