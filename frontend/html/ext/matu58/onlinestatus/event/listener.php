<?php
/*
*
* @package Online Status
* @author matu58 (www.matiaslauriti.com.ar)
* @copyright (c) 2015 by matu58 (www.matiaslauriti.com.ar)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* 
*/

namespace matu58\onlinestatus\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'matu58/onlinestatus',
			'lang_set' => 'onlinestatus',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
