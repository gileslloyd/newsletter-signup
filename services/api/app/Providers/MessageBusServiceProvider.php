<?php
declare(strict_types=1);

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use App\Message\MessageBus;

class MessageBusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MessageBus::class, function ($app) {
            return new MessageBus(config('rabbit'));
        });
    }
}
