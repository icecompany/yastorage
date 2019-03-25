<?php
defined('_JEXEC') or die;
class YastorageHelper
{
    public static function getParam(string $param)
    {
        $config = JComponentHelper::getParams('com_yastorage');
        return $config->get($param);
    }

    public function addSubmenu($vName)
    {
        JHtmlSidebar::addEntry(JText::sprintf('COM_YASTORAGE'), 'index.php?option=com_yastorage&view=yastorage', $vName == 'yastorage');
    }

    public static function getStorageType(string $type): string
    {
        return JText::sprintf("COM_YASTORAGE_HEAD_OBJECT_STORAGE_CLASS_{$type}");
    }
}
