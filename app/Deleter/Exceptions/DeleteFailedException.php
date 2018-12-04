<?php namespace App\Deleter\Exceptions;

/**
 * Class DeleteFailedException
 * @package App\Deleter\Exceptions
 */
class DeleteFailedException extends \RuntimeException
{

    /**
     * @var string
     */
    private $hostname;

    /**
     * DeleteFailedException constructor.
     * @param $hostname
     * @param $message
     */
    public function __construct($hostname, $message, $code = 0, Throwable $t = null) {
        $this->hostname = $hostname;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

}
