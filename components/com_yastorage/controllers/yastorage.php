<?php
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;

class YastorageControllerYastorage extends BaseController
{
    public function getLink()
    {
        $model = new YastorageModelSapi();
        $key = $this->input->getString('key');
        $url = $model->download($key);
        $this->setRedirect($url);
        $this->redirect();
        jexit();
    }
}
