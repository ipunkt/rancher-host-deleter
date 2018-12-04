<?php namespace Tests\Unit\Deleter\RancherCli;

use App\Deleter\RancherCli\HostOutputParser;
use Tests\TestCase;

/**
 * Class HostOutputParser
 * @package Tests\Unit\Deleter\RancherCli
 */
class HostOutputParserTest extends TestCase
{
    /**
     * @test
     * @param $hostname
     * @param $output
     * @param $expectedId
     * @dataProvider data
     */
    public function findsHostname($expectedId, $hostname, $output)
    {
        /**
         * @var HostOutputParser $parser
         */
        $parser = \App::make(HostOutputParser::class);

        $id = $parser->findHostId($hostname, $output);

        $this->assertEquals($expectedId, $id);
    }

    public function data()
    {
        return [
            ['1h18', 'lb01.acme.website', file_get_contents(__DIR__.'/output.txt')],
            ['1h19', 'lb02.acme.website', file_get_contents(__DIR__.'/output.txt')],
            ['1h59', 'cloud-web01', file_get_contents(__DIR__.'/output.txt')],
            ['1h60', 'cloud-web02', file_get_contents(__DIR__.'/output.txt')],
            [null, 'random', file_get_contents(__DIR__.'/output.txt')],
            [null, 'ccloud-web01', file_get_contents(__DIR__.'/output.txt')],
            [null, 'cloud-web011', file_get_contents(__DIR__.'/output.txt')],
        ];
    }
}
