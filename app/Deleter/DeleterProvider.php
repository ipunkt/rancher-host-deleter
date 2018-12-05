<?php namespace App\Deleter;

use App\Deleter\RancherCli\HostOutputParser;
use App\Deleter\RancherCli\Deleter as RancherCliDeleter;
use App\Deleter\SlackMessage\Deleter as SlackMessageDeleter;
use Illuminate\Support\ServiceProvider;

/**
 * Class DeleterProvider
 * @package App\Deleter
 */
class DeleterProvider extends ServiceProvider
{
    public function register()
    {
        switch( config('app.deleter') ) {
            case "slack":
                $this->bindSlackDeleter();
            break;
            default:
                $this->bindRancherCliDeleter();
                break;
        }
    }

    private function bindRancherCliDeleter(): void
    {
        $this->app->bind(Deleter::class, function () {
            $deleter = new RancherCliDeleter(new HostOutputParser());

            return $deleter
                ->setRancherUrl(config('rancher.url'))
                ->setAccessKey(config('rancher.access-key'))
                ->setSecretKey(config('rancher.secret-key'));
        });
    }

    private function bindSlackDeleter()
    {
        $this->app->bind(Deleter::class, function () {
            $deleter = new SlackMessageDeleter();

            return $deleter
                ->setUrl( config('slack.url') );
        });
    }
}
