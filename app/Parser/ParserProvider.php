<?php namespace App\Parser;

use Illuminate\Support\ServiceProvider;

/**
 * Class ParserProvider
 * @package App\Parser
 */
class ParserProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(HostnameParser::class, GrafanaParser::class);
    }

}
