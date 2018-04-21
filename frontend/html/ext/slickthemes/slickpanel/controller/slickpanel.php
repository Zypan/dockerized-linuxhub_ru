<?php
/*
 * Slickthemes slickpanel
 * Copyright (c) 2015 slickthemes
 * Licence:" proprietary
 */

namespace slickthemes\slickpanel\controller;

class slickpanel {
	protected $auth;
	protected $config;
	protected $config_text;
	protected $user;
	protected $php_ext;
	protected $template;
	protected $helper;
	protected $root_path;
	protected $userconfig;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper, $root_path, $php_ext, \slickthemes\slickpanel\controller\userconfig $userconfig){
		$this->auth = $auth;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->template = $template;
		$this->user = $user;
		$this->helper = $helper;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->userconfig = $userconfig;
	}

	public function full(){
		if (!$this->auth->acl_get('a_styles')){
			return $this->helper->error('No permission', 403);
		}
		$this->slickpanel_userconfig();
		return $this->helper->render('slickpanel/page.html', 'slickpanel', 200);
	}

	public function page(){
		if (!$this->auth->acl_get('a_styles')){
			return $this->helper->error('No permission', 403);
		}
		$this->slickpanel_userconfig();
		
		return $this->helper->render('slickpanel/page_inner.html', 'slickpanel', 200);
	}

  protected function slickpanel_userconfig() {
     add_form_key('slickpanel_userconfig');
  }
}