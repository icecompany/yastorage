<?php
use Joomla\CMS\MVC\Model\ListModel;

defined('_JEXEC') or die;

class YastorageModelYastorage extends ListModel
{
    public function __construct(array $config = array())
    {
        parent::__construct($config);
    }

    public function getStatus(): array
    {
        $status = YastorageHelper::testConnection();
        return $status;
    }

    public function getBuckets()
    {
        $socket = YastorageHelper::testConnection();
        $server = YastorageHelper::getParam('server');
        $request = "/";
        $auth = YastorageHelper::getAuthorization($server, $request);
        //return $auth;
        $in = "GET {$request} HTTP/1.1\n";
        $in .= "Host: {$server}\n";
        $in .= "Date: ".JDate::getInstance()->format("Y-m-d H:i:s")."\n";
        $in .= "Authorization: {$auth}\n";
        $exp = time() + 86400;
        $in .= "Expires: {$exp}\n";
        $out = '';
        $result = '';
        socket_write($socket['socket'], $in, strlen($in));
        while ($out = socket_read($socket['socket'], 2048)) {
            $result .= $out;
        }
        socket_close($socket['socket']);
        return $result;
    }
}
