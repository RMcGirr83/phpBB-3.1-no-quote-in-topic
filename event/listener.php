<?php
/**
*
* No Quote In Topic extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\noquoteintopic\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	// Change to false to not allow admins and mods to be able to quote
	const IGNORE_ADMINS_MODS = true;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\user */
	protected $user;

	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\user $user)
	{
		$this->auth = $auth;
		$this->user = $user;
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
			'core.viewtopic_modify_post_row'			=> 'viewtopic_modify_post_row',
			'core.modify_posting_auth'					=> 'no_quote_in_topic',
		);
	}

	/**
	* Modify the viewtopic post row
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_post_row($event)
	{
		if (self::IGNORE_ADMINS_MODS && $this->admins_and_mods())
		{
			return;
		}
		$post_row = $event['post_row'];
		$no_quote = array('U_QUOTE' => false);
		$event['post_row'] = array_merge($post_row, $no_quote);
	}

	/**
	* Don't allow quoting
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function no_quote_in_topic($event)
	{
		if (self::IGNORE_ADMINS_MODS && $this->admins_and_mods())
		{
			return;
		}
		$this->user->add_lang_ext('rmcgirr83/noquoteintopic', 'common');
		if ($event['mode'] == 'quote')
		{
			trigger_error('NO_QUOTING');
		}
	}

	private function admins_and_mods()
	{
		// grab all admins
		$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
		$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();

		//grab all mods
		$mod_ary = $this->auth->acl_get_list(false,'m_', false);
		$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();

		$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
		if (sizeof($admin_mod_array))
		{
			if (in_array($this->user->data['user_id'], $admin_mod_array))
			{
				return true;
			}
		}
		return false;
	}
}
