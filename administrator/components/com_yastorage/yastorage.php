<?php
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_yastorage'))
{
	throw new InvalidArgumentException(JText::sprintf('JERROR_ALERTNOAUTHOR'), 404);
}

// Require the helper
require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/yastorage.php';
require_once JPATH_LIBRARIES . '/AWS/aws-autoloader.php';
require_once JPATH_LIBRARIES . '/classSimpleImage.php';

// Execute the task
$controller = BaseController::getInstance('yastorage');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
