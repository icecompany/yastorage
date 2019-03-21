<?php
defined('_JEXEC') or die;

class YastorageHelper
{
    public static function testConnection(): array
    {
        $result = array('is_error' => false, 'error_msg' => '', 'socket');
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if ($socket === false) return self::getSocketError();

        $port = getservbyname('www', 'tcp');
        $connect = socket_connect($socket, self::getParam('server'), $port);

        if ($connect === false) return self::getSocketError();
        $result['socket'] = $socket;

        return $result;
    }

    public static function getParam(string $param)
    {
        $config = JComponentHelper::getParams('com_yastorage');
        return $config->get($param);
    }

    public static function getAuthorization(string $host, string $url): string
    {
        $host = strtolower($host);
        //$url = urlencode($url);
        $dat = JDate::getInstance();
        $credentials = array();
        $credentials[] = self::getParam('key_id');
        $credentials[] = $dat->format("Ymd");
        $credentials[] = 'us-east-1';
        $credentials[] = 's3';
        $credentials[] = 'aws4_request';
        $params = array();
        $params['X-Amz-Algorithm'] = 'AWS4-HMAC-SHA256';
        $params['X-Amz-Credential'] = implode("/", $credentials);
        $params['X-Amz-Date'] = $dat->format("Ymd\THis\Z");
        $params['X-Amz-Expires'] = 86400;
        $params['X-Amz-SignedHeaders'] = 'host';
        $canonicalRequest = "GET\n";
        $canonicalRequest .= "{$url}\n";
        $canonicalRequest .= http_build_query($params)."\n";
        $canonicalRequest .= "host:{$host}\n";
        $canonicalRequest .= "host\n\n";
        $canonicalRequest .= "UNSIGNED-PAYLOAD";
        $credentials = array();
        $credentials[] = $dat->format("Ymd");
        $credentials[] = 'us-east-1';
        $credentials[] = 's3';
        $credentials[] = 'aws4_request';
        $stringToSign = 'AWS4-HMAC-SHA256'."\n";
        $stringToSign .= $dat->format("Ymd\THis\Z")."\n";
        $stringToSign .= implode("/", $credentials)."\n";
        $stringToSign .= strtolower(hash('sha256', $canonicalRequest));
        $secretKey = self::getParam('key_value');
        $dateKey = hash_hmac("sha256", "AWS4{$secretKey}", $dat->format("Ymd"));
        $dateRegionKey = hash_hmac("sha256", $dateKey, 'us-east-1');
        $dateRegionServiceKey = hash_hmac("sha256", $dateRegionKey, 's3');
        $signingKey = hash_hmac("sha256", $dateRegionServiceKey, 'aws4_request');
        $signature = hash_hmac("sha256", $signingKey, $stringToSign);
        $query = array();
        $query['X-Amz-Algorithm'] = 'AWS4-HMAC-SHA256';
        $query['X-Amz-Credential'] = self::getParam('key_id')."/".$dat->format("Ymd")."/us-east-1s3aws4_request";
        $query['X-Amz-Date'] = $dat->format("Ymd\THis\Z");
        $query['X-Amz-Expires'] = 86400;
        $query['X-Amz-SignedHeaders'] = 'host';
        $query['X-Amz-Signature'] = $signature;
        //return "https://{$host}{$url}?".http_build_query($query);
        //return "https://{$host}{$url}?".http_build_query($query);
        $result = "Authorization: AWS4-HMAC-SHA256\n";
        $result .= "Credential=".implode("/", $credentials).",";
        $result .= "SignedHeaders=host,";
        $result .= "Signature={$signature}";
        return $signature;
    }

    public function addSubmenu($vName)
    {
        JHtmlSidebar::addEntry(JText::sprintf('COM_YASTORAGE'), 'index.php?option=com_yastorage&view=yastorage', $vName == 'yastorage');
    }

    public static function getSocketError(): array
    {
        return array('is_error' => true, 'error_msg' => socket_strerror(socket_last_error()));
    }
}
