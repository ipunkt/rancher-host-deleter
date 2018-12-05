<?php namespace App\Deleter\Exceptions;

use Throwable;

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
     * @param int $code
     * @param Throwable|null $t
     */
    public function __construct($hostname, $message, $code = 0, Throwable $t = null) {
        $this->hostname = $hostname;
        parent::__construct($message, $code, $t);
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

}
