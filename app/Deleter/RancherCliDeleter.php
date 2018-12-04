<?php namespace App\Deleter;

use Symfony\Component\Process\Process;

/**
 * Class RancherCliDeleter
 * @package App\Deleter
 */
class RancherCliDeleter implements Deleter
{

    /**
     * @param string $hostname
     * @throws \RuntimeException
     */
    public function deleteHost(string $hostname)
    {
        $nodesProcess = new Process(['rancher']);
    }
}
