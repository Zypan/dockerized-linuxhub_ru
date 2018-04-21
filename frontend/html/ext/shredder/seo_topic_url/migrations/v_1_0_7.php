<?php

/**
*
* @package SEO Topic URL
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\seo_topic_url\migrations;

class v_1_0_7 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['stc_version']) && version_compare($this->config['stc_version'], '1.0.7', '>=');
	}

	static public function depends_on()
	{
		return array('\shredder\seo_topic_url\migrations\v_1_0_6');
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.update', array('stc_version', '1.0.7')),
		);
	}
}
