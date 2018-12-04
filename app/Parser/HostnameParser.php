<?php namespace App\Parser;

use Illuminate\Http\Request;

/**
 * Interface HostnameParser
 * @package App\Parser
 */
interface HostnameParser
{
    /**
     * Parse request for hostnames to delete
     *
     * @param Request $request
     * @return string[]
     */
    function parseHosts(Request $request);

}
