<?php namespace App\Deleter\RancherCli;

/**
 * Class HostOutputParser
 * @package App\Deleter\RancherCli
 */
class HostOutputParser
{
    /**
     * @param string $hostname
     * @param string $rancherHostsOutput
     * @return mixed
     */
    public function findHostId(string $hostname, string $rancherHostsOutput)
    {
        $lines = explode( PHP_EOL, $rancherHostsOutput );

        foreach($lines as $line) {
            $matches = [];
            if( preg_match('/^(\S+)\s+(\S+)\s+.*/', $line, $matches) !== 1 )
                continue;

            if( $matches[2] === $hostname )
                return $matches[1];
        }

        return null;
    }
}
