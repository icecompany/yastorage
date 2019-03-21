<?php
/**
 * @package    yastorage
 *
 * @author     Admin <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

use Joomla\CMS\Table\Table;

defined('_JEXEC') or die;

/**
 * Yastorage table.
 *
 * @since       1.0
 */
class TableYastorage extends Table
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  $db  Database driver object.
	 *
	 * @since   1.0
	 */
	public function __construct(JDatabaseDriver $db)
	{
		parent::__construct('#__yastorage_items', 'item_id', $db);
	}
}