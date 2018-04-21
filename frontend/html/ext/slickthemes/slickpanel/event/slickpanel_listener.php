<?php
/*
 * Slickthemes slickpanel
 * Copyright (c) 2015 slickthemes
 * Licence:" proprietary
 */

namespace slickthemes\slickpanel\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class slickpanel_listener implements EventSubscriberInterface {

  protected $config;
  protected $config_text;
  protected $template;
  protected $user;
  protected $helper;
  protected $request;

  static public function getSubscribedEvents() {
    return array(
       'core.page_header'  			=> 'slickpanel_'
    );
  }

  public function __construct(
	  \phpbb\config\config $config,
	  \phpbb\config\db_text $config_text,
	  \phpbb\template\template $template,
	  \phpbb\user $user,
	  \phpbb\controller\helper $helper,
      \phpbb\request\request $request
  ){
    $this->config 		= $config;
    $this->config_text 	= $config_text;
    $this->template 	= $template;
    $this->user 		= $user;
    $this->helper 		= $helper;
    $this->request = $request;
  }

  public function slickpanel_($event) {
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


	//template variables
    $this->template->assign_vars(array(
		'SLICKPANEL_INSTALLED'		=> true,
		'SLICKPANEL_USERCONFIG'		=> $this->helper->route('slickpanel_userconfig'),
		'SLICKPANEL_LINK'          	=> $this->helper->route('slickpanel_home'),
		'SLICKPANEL_PAGE_LINK'      => $this->helper->route('slickpanel_page'),
		'ST_BIGSTRING' => json_decode(html_entity_decode($this->config_text->get('ST_BIGSTRING'))),
        'ST_AJAX_REQUEST' => $this->request->is_ajax()
    ));

	foreach ($settings as &$setting) {
		$this->template->assign_var($setting, $this->config[$setting]);
	}

  }
}
