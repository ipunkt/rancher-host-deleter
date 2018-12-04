<?php namespace App\Deleter;

use Illuminate\Support\ServiceProvider;

/**
 * Class DeleterProvider
 * @package App\Deleter
 */
class DeleterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Deleter::class, DummyDeleter::class);
    }
}
