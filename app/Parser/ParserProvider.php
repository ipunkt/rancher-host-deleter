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
        switch ( config('app.parser') ) {
            case 'simple':
                $this->app->bind(HostnameParser::class, SimpleParser::class);
                break;
            case 'log':
                $this->app->bind(HostnameParser::class, LogParser::class);
                break;
            default:
                $this->app->bind(HostnameParser::class, GrafanaParser::class);
                break;
        }
    }

}
