<?php
/**
*
* @package NavBar Search Extension
* @copyright (c) 2015 hifikabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\navbarsearch\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
   /** @var \phpbb\template\twig\twig */
   protected $template;

   /**
   * Constructor for listener
   *
   * @param \phpbb\config\config $config phpBB config
   * @param \phpbb\template\twig\twig $template phpBB template
   * @access public
   */
   public function __construct(\phpbb\template\twig\twig $template)
   {
      $this->template = $template;
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
         'core.page_header_after' => 'nav_bar_header',
      );
   }

   /**
   * Update the template variables
   *
   * @param object $event The event object
   * @return null
   * @access public
   */
   public function nav_bar_header($event)
   {
      $this->template->assign_vars(array(
         'S_IN_SEARCH' => true,
      ));
   }
}
