<?php
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

class YastorageViewYastorage extends HtmlView
{
	protected $helper, $sidebar, $state, $pagination, $uploadAction;
	public $items;

	public function display($tpl = null)
	{
		// Show the toolbar
		$this->toolbar();

		// Show the sidebar
		$this->helper = new YastorageHelper;
		$this->helper->addSubmenu('yastorage');
		$this->sidebar = JHtmlSidebar::render();
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->uploadAction = $this->get('uploadAction');

		// Display it all
		return parent::display($tpl);
	}

	private function toolbar()
	{
		JToolBarHelper::title(JText::sprintf('COM_YASTORAGE'), '');

		// Options button.
		if (JFactory::getUser()->authorise('core.admin', 'com_yastorage'))
		{
			JToolBarHelper::preferences('com_yastorage');
		}
	}
}
