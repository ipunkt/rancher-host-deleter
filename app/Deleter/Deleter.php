<?php namespace App\Deleter;

/**
 * Interface Deleter
 * @package App\Deleter
 */
interface Deleter
{

    /**
     * @param string $hostname
     * @throws \RuntimeException
     */
    function deleteHost(string $hostname);

}
