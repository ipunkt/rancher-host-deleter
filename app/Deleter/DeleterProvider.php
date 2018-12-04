<?php namespace App\Deleter;

use App\Deleter\RancherCli\HostOutputParser;
use App\Deleter\RancherCli\RancherCliDeleter;
use Illuminate\Support\ServiceProvider;

/**
 * Class DeleterProvider
 * @package App\Deleter
 */
class DeleterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Deleter::class, function() {
            $deleter = new RancherCliDeleter( new HostOutputParser() );

            return $deleter
                ->setRancherUrl( config('rancher.url') )
                ->setAccessKey( config('rancher.access-key') )
                ->setSecretKey( config('rancher.secret-key') );
        });
    }
}
