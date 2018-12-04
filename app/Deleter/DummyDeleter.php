<?php namespace App\Deleter;

/**
 * Class DummyDeleter
 * @package App\Deleter
 */
class DummyDeleter implements Deleter
{

    /**
     * @param string $hostname
     * @throws \RuntimeException
     */
    public function deleteHost(string $hostname)
    {
        // Do nothing. This is a dummy / testing deleter
    }
}
