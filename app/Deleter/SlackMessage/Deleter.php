<?php namespace App\Deleter\SlackMessage;

/**
 * Class Deleter
 * @package App\Deleter\SlackMessage
 */
class Deleter implements \App\Deleter\Deleter
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $hostname
     * @throws \RuntimeException
     */
    public function deleteHost(string $hostname)
    {
        $messageData = [
            'text' => "Received request to delete $hostname"
        ];
        file_get_contents($this->url, false, [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($messageData)
            ]
        ]);
    }

    /**
     * @param string $url
     * @return Deleter
     */
    public function setUrl(string $url): Deleter
    {
        $this->url = $url;
        return $this;
    }
}
