<?php
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;
require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/yastorage.php';
require_once JPATH_LIBRARIES . '/AWS/aws-autoloader.php';
require_once JPATH_COMPONENT_ADMINISTRATOR . '/models/sapi.php';

$controller = BaseController::getInstance('yastorage');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
