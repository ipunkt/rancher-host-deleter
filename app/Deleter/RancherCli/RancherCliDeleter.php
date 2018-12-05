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
        list($hostId, $isDeactivated) = $this->findHostId($hostname);

        if(!$isDeactivated)
            $this->deactivateHost($hostname, $hostId);

        $this->removeHost($hostname, $hostId);
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

    /**
     * @param string $hostname
     * @return array
     */
    private function findHostId(string $hostname): array
    {
        $nodesProcess = new Process([
            'rancher',
            '--url',
            $this->rancherUrl,
            '--access-key',
            $this->accessKey,
            '--secret-key',
            $this->secretKey,
            'hosts',
        ]);
        $nodesProcess->run();

        if (!$nodesProcess->isSuccessful()) {
            throw new DeleteFailedException($hostname, 'Failed to get node list: ' . $nodesProcess->getErrorOutput());
        }

        $hostId = $this->hostOutputParser->findHostId($hostname, $nodesProcess->getOutput());

        // hostId was found among the active hosts
        if ( !empty($hostId) )
            return [$hostId, false];

        $inactiveNodesProcess = new Process([
            'rancher',
            '--url',
            $this->rancherUrl,
            '--access-key',
            $this->accessKey,
            '--secret-key',
            $this->secretKey,
            'hosts',
            '-a'
        ]);
        $inactiveNodesProcess->run();
        $hostId = $this->hostOutputParser->findHostId($hostname, $inactiveNodesProcess->getOutput());

        if (empty($hostId)) {
            throw new DeleteFailedException($hostname, 'Host not found in Rancher');
        }
        return [$hostId, true];
    }

    /**
     * @param string $hostname
     * @param $hostId
     */
    private function deactivateHost(string $hostname, $hostId): void
    {
        $deactivateProcess = new Process([
            'rancher',
            '--url',
            $this->rancherUrl,
            '--access-key',
            $this->accessKey,
            '--secret-key',
            $this->secretKey,
            'deactivate',
            '--type',
            'host',
            $hostId
        ]);
        $deactivateProcess->run();
        if (!$deactivateProcess->isSuccessful()) {
            throw new DeleteFailedException($hostname, 'Failed to delete node: ' . $deactivateProcess->getOutput());
        }
    }

    /**
     * @param string $hostname
     * @param $hostId
     */
    private function removeHost(string $hostname, $hostId): void
    {
        $deleteProcess = new Process([
            'rancher',
            '--url',
            $this->rancherUrl,
            '--access-key',
            $this->accessKey,
            '--secret-key',
            $this->secretKey,
            'rm',
            '--type',
            'host',
            $hostId
        ]);
        $deleteProcess->run();
        if (!$deleteProcess->isSuccessful()) {
            throw new DeleteFailedException($hostname, 'Failed to delete node: ' . $deleteProcess->getOutput());
        }
    }
}
