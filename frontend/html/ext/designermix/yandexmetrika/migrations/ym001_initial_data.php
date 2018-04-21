<?php
/**
*
* Yandex Metrika extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace designermix\yandexmetrika\migrations;

/**
* Migration stage 1: Initial data changes to the database
*/
class ym001_initial_data extends \phpbb\db\migration\migration
{
	/**
	* Add Yandex Metrika data to the database.
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			array('config.add', array('yandexmetrika_id', '')),
		);
	}
}
