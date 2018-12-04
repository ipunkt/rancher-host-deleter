<?php namespace App\Deleter\RancherCli;

use App\Deleter\Deleter;
use App\Deleter\Exceptions\DeleteFailedException;
use Symfony\Component\Process\Process;

/**
 * Class RancherCliDeleter
 * @package App\Deleter
 */
class RancherCliDeleter implements Deleter
{
    /**
     * @var HostOutputParser
     */
    private $hostOutputParser;

    /**
     * @var string
     */
    protected $rancherUrl = '';

    /**
     * @var string
     */
    protected $accessKey = '';

    /**
     * @var string
     */
    protected $secretKey = '';

    /**
     * RancherCliDeleter constructor.
     * @param HostOutputParser $hostOutputParser
     */
    public function __construct(HostOutputParser $hostOutputParser) {
        $this->hostOutputParser = $hostOutputParser;
    }

    /**
     * @param string $hostname
     * @throws \RuntimeException
     */
    public function deleteHost(string $hostname)
    {
        $nodesProcess = new Process([
            'rancher',
            '--url', $this->rancherUrl,
            '--access-key', $this->accessKey,
            '--secret-key', $this->secretKey,
            'hosts'
        ]);
        $nodesProcess->run();

        if( !$nodesProcess->isSuccessful() )
            throw new DeleteFailedException($hostname, 'Failed to get node list: '.$nodesProcess->getErrorOutput());

        $hostId = $this->hostOutputParser->findHostId($hostname, $nodesProcess->getOutput());
        if($hostId === null)
            throw new DeleteFailedException($hostname, 'Host not found in Rancher');

        $deleteProcess = new Process(['rancher', 'rm', $hostId]);
        $deleteProcess->run();
        if( !$deleteProcess->isSuccessful() )
            throw new DeleteFailedException($hostname, 'Failed to delete node: '.$deleteProcess->getErrorOutput());
    }

    /**
     * @param string $rancherUrl
     * @return RancherCliDeleter
     */
    public function setRancherUrl(string $rancherUrl): RancherCliDeleter
    {
        $this->rancherUrl = $rancherUrl;
        return $this;
    }

    /**
     * @param string $accessKey
     * @return RancherCliDeleter
     */
    public function setAccessKey(string $accessKey): RancherCliDeleter
    {
        $this->accessKey = $accessKey;
        return $this;
    }

    /**
     * @param string $secretKey
     * @return RancherCliDeleter
     */
    public function setSecretKey(string $secretKey): RancherCliDeleter
    {
        $this->secretKey = $secretKey;
        return $this;
    }
}
