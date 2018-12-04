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
        $nodesProcess = new Process(['rancher hosts']);
        $nodesProcess->run();

        if( !$nodesProcess->isSuccessful() )
            throw new DeleteFailedException($hostname, 'Failed to get node list: '.$nodesProcess->getErrorOutput());

        $hostId = $this->hostOutputParser->findHostId($hostname, $nodesProcess->getOutput());
        if($hostId === null)
            throw new DeleteFailedException($hostname, 'Host not found in Rancher');
    }
}
