<?php

/**
* @package SEO Meta Description
* @copyright (c) 2014 Anvar [apwa.ru]
* @link http://bb3.mobi
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*/

namespace bb3mobi\seodesc\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	protected $template;

	const MAX_LENGHT = 250;

	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.display_forums_modify_forum_rows'	=> 'forumlist_description',
			'core.viewforum_get_topic_data'			=> 'viewforum_description',
			'core.viewtopic_modify_post_data'		=> 'viewtopic_description',
		);
	}

	public function forumlist_description($event)
	{
		$forum_desc = '';
		$row = $event['row'];
		$forum_rows = $event['forum_rows'];
		foreach ($forum_rows as $row)
		{
			/** No forum type category */
			if ($row['forum_type'] != FORUM_CAT)
			{
				$forum_desc .= ($forum_desc) ? ', ' . $row['forum_name'] : $row['forum_name'];
			}
		}
		if ($forum_desc)
		{
			if (mb_strlen($forum_desc) > self::MAX_LENGHT)
			// if (strlen(utf8_decode($forum_desc)) > self::MAX_LENGHT)
			{
				$forum_desc = mb_substr($forum_desc, 0, self::MAX_LENGHT) . '..';
				// $forum_desc = substr($forum_desc, 0, self::MAX_LENGHT) . '..';
			}
			$this->template->assign_var('DESCRIPTION', trim($forum_desc));
		}
	}

	public function viewforum_description($event)
	{
		$forum_data = $event['forum_data'];
		if (!empty($forum_data['forum_desc']))
		{
			$forum_desc = $this->strip_code($forum_data['forum_desc']);
			if (mb_strlen($forum_desc) > self::MAX_LENGHT)
			// if (strlen(utf8_decode($forum_desc)) > self::MAX_LENGHT)
			{
				$forum_desc = mb_substr($forum_desc, 0, self::MAX_LENGHT) . '..';
				// $forum_desc = substr($forum_desc, 0, self::MAX_LENGHT) . '..';
			}
			$this->template->assign_var('DESCRIPTION', trim($forum_desc));
		}
	}

	public function viewtopic_description($event)
	{
		$topic_desc = '';
		$rowset = $event['rowset'];
		$post_list = $event['post_list'];
		for ($i = 0, $end = sizeof($post_list); $i < $end; ++$i)
		{
			// A non-existing rowset only happens if there was no user present for the entered poster_id
			// This could be a broken posts table.
			if (!isset($rowset[$post_list[$i]]))
			{
				continue;
			}
			$row = $rowset[$post_list[$i]];
			$topic_desc = $this->strip_code($row['post_text']);
			unset($rowset[$post_list[$i]]);
			break;
		}
		// Limit chars
		if (mb_strlen($topic_desc) >= self::MAX_LENGHT)
		// if (strlen(utf8_decode($topic_desc)) > self::MAX_LENGHT)
		{
			$topic_desc = mb_substr($topic_desc, 0, self::MAX_LENGHT) . '..';
			// $topic_desc = substr($topic_desc, 0, self::MAX_LENGHT) . '..';
		}
		$this->template->assign_var('DESCRIPTION', trim($topic_desc));
	}

	private function strip_code($text)
	{
		$text = censor_text($text);

		strip_bbcode($text);

		$text = str_replace(array("&quot;", "/", "\n", "\t", "\r"), ' ', $text);

		$text = preg_replace(array("|http(.*)jpg|isU", "@(http(s)?://)?(([a-z0-9.-]+)?[a-z0-9-]+(!?\.[a-z]{2,4}))@"), ' ', $text);

		return preg_replace("/[^A-ZА-ЯЁ.,-–?]+/ui", " ", $text);
	}
}
