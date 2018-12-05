<?php namespace App\Parser;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class LogParser
 * @package App\Parser
 *
 * This parser is used to find out the content of webhooks
 */
class LogParser implements HostnameParser
{

    /**
     * Parse request for hostnames to delete
     *
     * @param Request $request
     * @return string[]
     */
    public function parseHosts(Request $request)
    {
        $input = $request->input();

        $now = Carbon::now();
        $nowString = $now->format("Y-m-d_H-i-s-u");
        file_put_contents(storage_path("app/requests/${nowString}.json"), json_encode($input) );
        return [];
    }
}
