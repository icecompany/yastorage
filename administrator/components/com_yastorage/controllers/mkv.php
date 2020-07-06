<?php
use Joomla\CMS\MVC\Controller\AdminController;

defined('_JEXEC') or die;

class YastorageControllerMkv extends AdminController
{
    public function getModel($name = 'Mkv', $prefix = 'YastorageModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function download()
    {
        $model = $this->getModel();
        $key = $this->input->getString('key');
        $bucket = $this->input->getString('bucket');
        $url = $model->download($bucket, $key);
        $this->setRedirect($url);
        $this->redirect();
        jexit();
    }

    public function delete()
    {
        $model = $this->getModel();
        $key = $this->input->getString('key');
        $bucket = $this->input->getString('bucket');
        $model->delete($bucket, $key);
        $this->setRedirect(JUri::getInstance($_SERVER['HTTP_REFERER'])->toString());
        $this->redirect();
        jexit();
    }
}
