<?php

namespace Pythagus\LaravelAuthentificationLog;

use Illuminate\Support\ServiceProvider;

/**
 * Class AuthLogServiceProvider
 * @package Pythagus\LaravelAuthentificationLog
 *
 * @author: Damien MOLINA
 */
class AuthLogServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->register(AuthLogEventServiceProvider::class);

        $this->publishFiles() ;
    }

    /**
     * Publish specific files.
     *
     * @return void
     */
    private function publishFiles() {
        $publishTag = 'auth-log' ;

        $this->publishes(
            [__DIR__.'/Migrations' => database_path('migrations')], $publishTag.'-migrations'
        ) ;

        $this->publishes(
            [__DIR__.'/Models' => app_path()], $publishTag.'-models'
        ) ;
    }

}
