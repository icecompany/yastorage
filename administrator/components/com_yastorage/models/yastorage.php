<?php
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class YastorageModelYastorage extends ListModel
{
    protected $sapi;
    public function __construct(array $config = array())
    {
        $this->sapi = BaseDatabaseModel::getInstance('Sapi', 'YastorageModel');
        parent::__construct($config);
    }

    public function upload($url): array
    {
        $config = JComponentHelper::getParams($this->option);
        $t = mktime();
        $info = pathinfo($url);
        $fname = basename($url,'.'.$info['extension']);
        $destination = JPATH_SITE."/images/{$t}_{$fname}.{$info['extension']}";
        $path_full = JPATH_SITE."/images/{$t}_{$fname}_full.{$info['extension']}";
        $path_preview = JPATH_SITE."/images/{$t}_{$fname}_preview.{$info['extension']}";
        $this->downloadFile($url, $destination);
        $this->resize($destination, $path_full, $config->get('img_resize_x'));
        $this->sapi->upload('news', $path_full);
        @unlink($path_full);
        $this->resize($destination, $path_preview, $config->get('img_resize_preview_x'));
        $this->sapi->upload('news', $path_preview);
        @unlink($path_preview);
        @unlink($destination);
        return array('preview' => $path_preview, 'full' => $path_full);
    }

    /**
     * @param string $original путь с оригинальным изображением
     * @param string $destination путь для сохранения изображения
     * @param int $width размер по горизонтали
     * @since 1.0.0.2
     */
    private function resize(string $original = '', string $destination = '', int $width = 1): void
    {
        $image = new SimpleImage();
        $image->load($original);
        $image->resizeToWidth($width);
        $image->save($destination);
    }

    function downloadFile($URL, $PATH) {
        $ReadFile = fopen ($URL, "rb");
        if ($ReadFile) {
            $WriteFile = fopen ($PATH, "wb");
            if ($WriteFile){
                while(!feof($ReadFile)) {
                    fwrite($WriteFile, fread($ReadFile, 4096 ));
                }
                fclose($WriteFile);
            }
            fclose($ReadFile);
        }
    }

    public function getItems()
    {
        $items = $this->sapi->listObjects();
        $result = array();
        foreach ($items as $item) {
            $arr = array();
            $arr['key'] = $item['Key'];
            $arr['size'] = round($item['Size'] / 1024) . " K";
            $date = JDate::getInstance($item['LastModified']);
            $arr['modified'] = $date->format("d.m.Y H:i:s");
            $arr['storage'] = YastorageHelper::getStorageType(mb_strtoupper($item['StorageClass']));
            $arr['link'] = JRoute::link("site", "index.php?option=com_yastorage&amp;task=yastorage.getLink&amp;key={$item['Key']}");
            $result[$item['Key']] = $arr;
        }
        krsort($result);
        return $result;
    }

    public function getUploadAction(): string
    {
        return JRoute::_("index.php?option={$this->option}&amp;task=yastorage.upload");
    }
}
