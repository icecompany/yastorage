<?php
use Joomla\CMS\MVC\Controller\AdminController;

defined('_JEXEC') or die;

class YastorageControllerYastorage extends AdminController
{
    public function getModel($name = 'Sapi', $prefix = 'YastorageModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function upload()
    {
        $model = $this->getModel('Yastorage', 'YastorageModel');
        $model->upload($_POST['jform']['url']);
        $this->setRedirect('index.php?option=com_yastorage');
        $this->redirect();
        jexit();
    }

    public function getLink()
    {
        $model = $this->getModel();
        $key = $this->input->getString('key');
        $url = $model->download($key);
        $this->setRedirect($url);
        $this->redirect();
        jexit();
    }
}
