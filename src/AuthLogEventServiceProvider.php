<?php

namespace Pythagus\LaravelAuthentificationLog;

use Illuminate\Auth\Events\Login;
use Pythagus\LaravelAuthentificationLog\Listeners\AuthentificationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class AuthLogServiceProvider
 * @package Pythagus\LaravelAuthentificationLog
 *
 * @author: Damien MOLINA
 */
class AuthLogEventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            AuthentificationListener::class,
        ],
    ] ;

}
