<?php
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Aws\S3\S3Client;

class YastorageModelSapi extends BaseDatabaseModel
{
    protected $server, $key_id, $key_value, $region, $version, $shared_config, $bucket;
    public function __construct(array $config = array())
    {
        $this->server = YastorageHelper::getParam('server');
        $this->region = YastorageHelper::getParam('region');
        $this->key_id = YastorageHelper::getParam('key_id');
        $this->key_value = YastorageHelper::getParam('key_value');
        $this->version = YastorageHelper::getParam('version');
        $this->bucket = YastorageHelper::getParam('bucket');
        $this->shared_config = [
            'region' => $this->region,
            'version' => $this->version,
            'endpoint' => $this->server,
            'credentials' => ['key' => $this->key_id, 'secret' => $this->key_value]
        ];
        parent::__construct($config);
    }

    public function upload(string $prefix, string $url)
    {
        $s3 = new S3Client($this->shared_config);
        $key = basename($url);
        $s3->putObject([
            'Bucket'     => $this->bucket,
            'Key'        => "{$prefix}/{$key}",
            'SourceFile' => $url,
            'ACL'        => 'private',
        ]);
    }

    public function download(string $key): string
    {
        $s3 = new S3Client($this->shared_config);
        $cmd = $s3->getCommand('GetObject',['Bucket' => $this->bucket, 'Key' => $key]);
        $signed_url = $s3->createPresignedRequest($cmd, '+1 hour');
        return (string) $signed_url->getUri();
    }

    public function listObjects(): array
    {
        $s3 = new S3Client($this->shared_config);
        $objects = $s3->listObjectsV2(['Bucket' => $this->bucket]);
        $tmp = $objects->toArray();
        return $tmp['Contents'];
    }
}