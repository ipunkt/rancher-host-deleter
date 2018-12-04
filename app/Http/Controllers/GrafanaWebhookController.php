<?php

namespace App\Http\Controllers;

use App\Deleter\Deleter;
use App\Deleter\Exceptions\DeleteFailedException;
use App\Parser\HostnameParser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GrafanaWebhookController extends Controller {
    /**
     * @var HostnameParser
     */
    private $parser;
    /**
     * @var Deleter
     */
    private $deleter;

    /**
     * GrafanaWebhookController constructor.
     * @param HostnameParser $parser
     * @param Deleter $deleter
     */
    public function __construct(HostnameParser $parser, Deleter $deleter) {
        $this->parser = $parser;
        $this->deleter = $deleter;
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request) {
        $hostnames = $this->parser->parseHosts($request);

        $deletedHosts = [];
        $failedHosts = [];
        foreach($hostnames as $hostname) {
            try {
                $this->deleter->deleteHost($hostname);
                $deletedHosts[] = $hostname;
            } catch(DeleteFailedException $exception) {
                $failedHosts[] = $exception;
            }
        }

        $hasSuccessful = !empty($deletedHosts);
        $hasFailed = !empty($failedHosts);
        if( $hasSuccessful && $hasFailed )
            return \Response::json([
                'deleted-hosts' => $deletedHosts,
                'failed-hosts' => $this->makeFailedList($failedHosts),
            ], 207);

        if( $hasFailed ) {
            return \Response::json([
                'failed-hosts' => $this->makeFailedList($failedHosts),
            ], 500);
        }

        return \Response::json([
            'deleted-hosts' => $deletedHosts,
        ], 200);
    }

    /**
     * @param DeleteFailedException[] $failedHosts
     * @return array
     */
    protected function makeFailedList($failedHosts) {
        $list = [];

        foreach($failedHosts as $failedHost)
            $lists[$failedHost->getHostname()] = $failedHost->getMessage();

        return $list;
    }
}
