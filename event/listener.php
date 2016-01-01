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

	/** @var \phpbb\user */
	protected $user;

	public function __construct(
		\phpbb\user $user)
	{
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
		$post_row = $event['post_row'];
		$no_quote = array('U_QUOTE' => false);
		$event['post_row'] = array_merge($post_row, $no_quote);
	}

	/**
	* Don' allow quoting
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function no_quote_in_topic($event)
	{

		$this->user->add_lang_ext('rmcgirr83/noquoteintopic', 'common');
		if ($event['mode'] == 'quote')
		{
			trigger_error('NO_QUOTING');
		}
	}
}
