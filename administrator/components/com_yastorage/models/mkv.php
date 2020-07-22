<?php
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Aws\S3\S3Client;

class YastorageModelMkv extends BaseDatabaseModel
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

    public function upload(string $bucket, string $prefix, string $url, string $name)
    {
        $s3 = new S3Client($this->shared_config);
        $full = "{$prefix}/{$name}";
        if (!file_exists($url)) return;
        $s3->putObject([
            'Bucket'     => $bucket,
            'Key'        => $full,
            'SourceFile' => $url,
            'ACL'        => 'private',
        ]);
        return JRoute::_("index.php?option={$this->option}&amp;task=mkv.download&amp;bucket={$bucket}&amp;key={$full}");
    }

    public function download(string $bucket, string $key): string
    {
        $s3 = new S3Client($this->shared_config);
        $cmd = $s3->getCommand('GetObject',['Bucket' => $bucket, 'Key' => $key]);
        $signed_url = $s3->createPresignedRequest($cmd, '+1 hour');
        return (string) $signed_url->getUri();
    }

    public function delete(string $bucket, string $key): void
    {
        $s3 = new S3Client($this->shared_config);
        $s3->deleteObject(['Bucket' => $bucket, 'Key' => $key]);
    }

    public function listObjects(string $bucket, string $prefix = ''): array
    {
        $s3 = new S3Client($this->shared_config);
        $params = ['Bucket' => $bucket];
        if (!empty($prefix)) $params['Prefix'] = $prefix;
        $objects = $s3->listObjectsV2($params);
        if (empty($objects)) return [];
        $tmp = $objects->toArray();
        return $tmp['Contents'] ?? [];
    }

    public function getLink(string $bucket, string $key): string
    {
        $s3 = new S3Client($this->shared_config);
        $cmd = $s3->getCommand('GetObject',['Bucket' => $bucket, 'Key' => $key]);
        $signed_url = $s3->createPresignedRequest($cmd, '+1 hour');
        return (string) $signed_url->getUri();
    }
}