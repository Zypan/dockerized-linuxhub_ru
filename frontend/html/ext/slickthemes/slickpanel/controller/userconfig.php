<?php
/*
 * Slickthemes slickpanel
 * Copyright (c) 2015 slickthemes
 * Licence:" proprietary
 */

namespace slickthemes\slickpanel\controller;

class userconfig {

  protected $auth;
  protected $config;
  protected $config_text;
  protected $request;
  protected $user;
  protected $helper;

  public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\request\request $request, \phpbb\user $user, \phpbb\controller\helper $helper) {
    $this->auth = $auth;
    $this->config = $config;
    $this->config_text = $config_text;
    $this->request = $request;
    $this->user = $user;
    $this->helper = $helper;
  }

  public function manage() {
	if ($this->request->is_ajax()){
		$json_response = new \phpbb\json_response;
		//check permissions
		if (!$this->auth->acl_get('a_styles')) {
			$responseData = array('MESSAGE_TITLE' => 'Error', 'MESSAGE_TEXT' => "No permission");
			$json_response->send($responseData);
			return;
		}
		//validate form key
		if(!check_form_key('slickpanel_userconfig')) {
			$responseData = array('MESSAGE_TITLE' => 'Error', 'MESSAGE_TEXT' => 'Invalid Form key');
			$json_response->send($responseData);
			return;
		}
	}
	else {
		//make sure user has permissions
		if (!$this->auth->acl_get('a_styles')) {
		  return $this->helper->error('No permission', 403);
		}
		//validate form key
		if(!check_form_key('slickpanel_userconfig')) {
		  return $this->helper->error('Invalid form key', 400);
		}
	}


	$settings = array(

		//Body
		'ST_body__bgcolor',
		'ST_body__bgimg_url',
		'ST_body__bgimg_pos',
		'ST_body__bgimg_size',
		'ST_body__bgimg_repeat',

		//fonts
		'ST_type__body_fontfamily',
		'ST_type__navbar_fontfamily',
		'ST_type__content_fontfamily',
		'ST_type__content_fontsize',

		//link colors
		'ST_colors__primary',
		'ST_colors__link',
		'ST_colors__linkhover',

		//Header
		'ST_header__height',
		'ST_header__transparent',
		'ST_header__bgcolor',
		'ST_header__bgimg_url',
		'ST_header__bgimg_pos',
		'ST_header__bgimg_size',
		'ST_header__bgimg_repeat',

		//Search
		'ST_search__bgcolor',
		'ST_search__focusbgcolor',
		'ST_search__color',
		'ST_search__placeholder',

		//Footer
		'ST_footer__bgcolor',
		'ST_footer__fgcolor',
		'ST_footer__bgimg_url',
		'ST_footer__bgimg_pos',
		'ST_footer__bgimg_size',
		'ST_footer__bgimg_repeat',

		//Logo
		'ST_logo__type',
		'ST_logo__image_filename',
		'ST_logo__image_width',
		'ST_logo__text',
		'ST_logo__fontsize',
		'ST_logo__fontfamily',
		'ST_logo__fontweight',
		'ST_logo__color',

		//layout
		'ST_container__type',
		'ST_container__width',
		'ST_navbar__pos',
		'ST_breadcrumbs__detach',
		'ST_post_authorAlign',
		'ST_sidebar__index',
		'ST_sidebar__forum',
		'ST_sidebar__topic',
		'ST_oneall__header',

        //Topic author
        'ST_topicAuthorLabel',
        'ST_topicAuthorLabel__text',
        'ST_topicAuthorLabel__bg',

		//Social icons
		'ST_social_fb',
		'ST_social_twitter',
		'ST_social_gplus',
		'ST_social_youtube',

		//features
		'ST_wysiwyg',
		'ST_complex_footer',
		'ST_dark_navbar',
		'ST_timestamps',
		'ST_roundAvatars',
		'ST_pinchzoom',
		'ST_fastclick',
		'ST_quickscroll',
		'ST_stickyheader',
		'ST_modern_item_stats',
		'ST_g_analytics_ID',
		'ST_c_analytics_ID',
		'ST_grayscale_icons'
	);

    if($this->request->is_set_post('submit_userconfig')) {

		//set values
		foreach ($settings as &$setting) {
			$this->config->set($setting, $this->request->variable($setting,'0'));
		}

		$this->config_text->set('ST_BIGSTRING', $this->request->variable('ST_BIGSTRING', '0'));

    }

	//Notify user
	 if ($this->request->is_ajax()){
			$responseData = array('Success' => true, 'MESSAGE_TITLE' => 'Success', 'MESSAGE_TEXT' => 'Settings saved!');
			$json_response->send($responseData);
			return;
	 } else {
		return $this->helper->message('Settings saved', array(), 'Success', 200);
	}
  }

}
