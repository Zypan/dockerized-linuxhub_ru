<?php

/**
*
* @package SEO Topic URL
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\seo_topic_url\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\template */
	protected $template;

	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $php_ext;

	/**
	* Constructor
	* 
	* @param \phpbb\template\template $template
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\user $user, $php_ext)
	{
		$this->config = $config;
		$this->db = $db;
		$this->template = $template;
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->user = $user;
		$this->php_ext = $php_ext;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'acp_board_features_config',
			'core.index_modify_page_title'		=> 'index_modify_canonical_url',
			'core.viewtopic_modify_page_title'	=> 'viewtopic_modify_canonical_url',
			'core.submit_post_end'			=> 'remove_params_on_posting',
			'core.update_session_after'		=> 'who_is_online_fix',
			'core.page_footer_after'		=> array('remove_forum_id', -5),
		);
	}

	/**
	* Extension configuration in Board features
	*/
	public function acp_board_features_config($event)
	{
		if ($event['mode'] == 'features')
		{
			$display_vars = $event['display_vars'];

			$add_config_var = array(
				'stc_acp_legend'	=> 'STC_ACP_LEGEND',
				'stc_mode'		=> array('lang' => 'STC_ACP_MODE', 'validate' => 'int', 'type' => 'custom', 'function' => array($this, 'select_stc_options'), 'explain' => true),
			);

			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_config_var, array('after' => 'load_cpf_viewtopic'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}

	public function select_stc_options($value, $key = '')
	{
		$radio_ary = array(0 => 'STC_ACP_OPTION_0', 1 => 'STC_ACP_OPTION_1', 2 => 'STC_ACP_OPTION_2');	

		return h_radio('config[stc_mode]', $radio_ary, $value, 'stc_mode', $key, '<br />');
	}

	/**
	* Rewrite the canonical URL on index.php
	*/
	public function index_modify_canonical_url($event)
	{
		$canonical = generate_board_url() . '/';

		// Check out for portal compatibility
		if ($this->phpbb_extension_manager->is_enabled('board3/portal'))
		{
			$canonical .= ($this->config['board3_enable']) ? 'index.' . $this->php_ext : '';
		}

		$this->template->assign_var('U_CANONICAL', $canonical);
	}

	/**
	* Rewrite the canonical URL on viewtopic.php
	*/
	public function viewtopic_modify_canonical_url($event)
	{
		$topic_id = $event['topic_data']['topic_id'];
		$forum_id = $event['topic_data']['forum_id'];
		$start = $event['start'];

		$canonical = '';

		if (!$this->config['stc_mode'])
		{
			$canonical = generate_board_url() . '/' . append_sid("viewtopic.$this->php_ext", "t=$topic_id" . (($start) ? "&amp;start=$start" : ''), true, '');
		}
		else if ($this->config['stc_mode'] == 1)
		{
			$canonical = generate_board_url() . '/' . append_sid("viewtopic.$this->php_ext", "f=$forum_id&amp;t=$topic_id" . (($start) ? "&amp;start=$start" : ''), true, '');
		}

		$this->template->assign_var('U_CANONICAL', $canonical);
	}

	/**
	* Remove f= and t= params on posting
	*/
	public function remove_params_on_posting($event)
	{
		if ($this->config['stc_mode'])
		{
			return;
		}

		$url = $event['url'];

		$url = str_replace('f=' . $event['data']['forum_id'] . '&amp;t=' . $event['data']['topic_id'] . '&amp;', '', $url);
		$url = str_replace('f=' . $event['data']['forum_id'] . '&amp;', '', $url);

		$event['url'] = $url;
	}

	/**
	* Shows what topic the user is viewing
	*/
	public function who_is_online_fix($event)
	{
		if ($this->config['stc_mode'])
		{
			return;
		}

		global $forum_id;

		if ($forum_id && !$this->user->page['forum'] && strpos($this->user->page['page_name'], 'viewtopic.' . $this->php_ext) !== false)
		{
			$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET session_forum_id = ' . $forum_id . '
				WHERE session_id = \'' . $this->db->sql_escape($this->user->session_id) . '\'
				AND session_user_id = ' . $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
		}
	}

	/**
	* Remove forum id from all topic URLs
	*/
	public function remove_forum_id($event)
	{
		if (!defined('PHPBB_WORK_INFO'))
		{
			$this->template->assign_vars(array(
				'PHPBB_WORK_STU'	=> ($this->config['default_lang'] == 'ru') ? true : false,
			));

			define('PHPBB_WORK_INFO', 1);
		}

		if ($this->config['stc_mode'])
		{
			return;
		}

		$display_template = $event['display_template'];

		if ($display_template)
		{
			ob_start();

			$this->template->display('body');

			$content = ob_get_clean();

			$urlin = array(
				"/\.\/viewtopic.$this->php_ext\?f=([0-9]*)&(?:amp;)(p|t)=([0-9]*)(.*?)\"/i",
			);
			$urlout = array(
				'./viewtopic.' . $this->php_ext . '?\\2=\\3\\4"',
			);

			echo preg_replace($urlin, $urlout, $content);

			$display_template = false;
		}

		$event['display_template'] = $display_template;
	}
}
