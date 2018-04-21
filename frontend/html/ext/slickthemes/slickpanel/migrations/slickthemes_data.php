<?php
/**
 * Author: Slickthemes
 * Copyright Slickthemes 2015
 */

namespace slickthemes\slickpanel\migrations;

class slickthemes_data extends \phpbb\db\migration\migration
{

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'install_bbcodes'))),
			array('config_text.add', array('slickpanelTESTTT', 'HAHAHAHA'))
		);
	}
	
	public function install_bbcodes($bbcode_data)
	{
		// Load the acp_bbcode class
		if (!class_exists('acp_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/acp/acp_bbcodes.' . $this->php_ext);
		}
		$bbcode_tool = new \acp_bbcodes();
		
		$bbcode_data = array(
			's' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[s]{TEXT}[/s]',
				'bbcode_tpl'		=> '<span class="bbcode-strikethrough">{TEXT}</span>',
			),
			'sub' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[sub]{TEXT}[/sub]',
				'bbcode_tpl'		=> '<sub>{TEXT}</sub>',
			),
			'sup' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[sup]{TEXT}[/sup]',
				'bbcode_tpl'		=> '<sup>{TEXT}</sup>',
			),
			'font=' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[font={INTTEXT}]{TEXT}[/font]',
				'bbcode_tpl'		=> '<span style="font-family: {INTTEXT};">{TEXT}</span>',
			),
			'left' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[left]{TEXT}[/left]',
				'bbcode_tpl'		=> '<span class="text-left">{TEXT}</span>'
			),
			'right' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[right]{TEXT}[/right]',
				'bbcode_tpl'		=> '<span class="text-right">{TEXT}</span>'
			),
			'center' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[center]{TEXT}[/center]',
				'bbcode_tpl'		=> '<span class="text-center">{TEXT}</span>'
			),
			'youtube' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[youtube]{IDENTIFIER}[/youtube]',
				'bbcode_tpl'		=> '<div class="video-embed-wrapper"><div class="video-wrap"><iframe width="560" height="315" src="https://www.youtube.com/embed/{IDENTIFIER}" data-youtube-id="{IDENTIFIER}" frameborder="0" allowfullscreen></iframe></div></div>',
				'display_on_posting'=> 0,
			),
			'vimeo' => array(
				'bbcode_helpline'	=> '',
				'bbcode_match'		=> '[vimeo]{IDENTIFIER}[/vimeo]',
				'bbcode_tpl'		=> '<div class="video-embed-wrapper"><div class="video-wrap"><iframe src="//player.vimeo.com/video/{IDENTIFIER}" data-vimeo-id="{IDENTIFIER}" width="560" height="315" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div></div>',
				'display_on_posting'=> 0,
			)
		);

		foreach ($bbcode_data as $bbcode_name => $bbcode_array)
		{
			// Build the BBCodes
			$data = $bbcode_tool->build_regexp($bbcode_array['bbcode_match'], $bbcode_array['bbcode_tpl']);

			$bbcode_array += array(
				'bbcode_tag'			=> $data['bbcode_tag'],
				'first_pass_match'		=> $data['first_pass_match'],
				'first_pass_replace'	=> $data['first_pass_replace'],
				'second_pass_match'		=> $data['second_pass_match'],
				'second_pass_replace'	=> $data['second_pass_replace']
			);

			$sql = 'SELECT bbcode_id
				FROM ' . BBCODES_TABLE . "
				WHERE LOWER(bbcode_tag) = '" . strtolower($bbcode_name) . "'
				OR LOWER(bbcode_tag) = '" . strtolower($bbcode_array['bbcode_tag']) . "'";
			$result = $this->db->sql_query($sql);
			$row_exists = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row_exists)
			{
				// Update existing BBCode
				$bbcode_id = $row_exists['bbcode_id'];

				$sql = 'UPDATE ' . BBCODES_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $bbcode_array) . '
					WHERE bbcode_id = ' . $bbcode_id;
				$this->db->sql_query($sql);
			}
			else
			{
				// Create new BBCode
				$sql = 'SELECT MAX(bbcode_id) AS max_bbcode_id
					FROM ' . BBCODES_TABLE;
				$result = $this->db->sql_query($sql);
				$max_bbcode_id = $this->db->sql_fetchfield('max_bbcode_id');
				$this->db->sql_freeresult($result);

				if ($max_bbcode_id)
				{
					$bbcode_id = $max_bbcode_id + 1;
					
					if ($bbcode_id <= NUM_CORE_BBCODES)
					{
						$bbcode_id = NUM_CORE_BBCODES + 1;
					}
				}
				else
				{
					$bbcode_id = NUM_CORE_BBCODES + 1;
				}

				if ($bbcode_id <= BBCODE_LIMIT)
				{
					$bbcode_array['bbcode_id'] = (int) $bbcode_id;
					$bbcode_array['display_on_posting'] = (int) 0;

					$this->db->sql_query('INSERT INTO ' . BBCODES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $bbcode_array));
				}
			}
		}
	}

	
}
