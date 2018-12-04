<?php namespace App\Parser;

use Illuminate\Http\Request;

/**
 * Class GrafanaParser
 * @package App\Parser
 */
class GrafanaParser implements HostnameParser
{

    /**
     * Parse request for hostnames to delete
     *
     * @param Request $request
     * @return string[]
     */
    public function parseHosts(Request $request)
    {
        return ['test1', 'test2'];
    }
}
