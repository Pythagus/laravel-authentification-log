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
		$this->loadMigrations() ;
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
	}

	/**
	 * Load the migrations only whether It
	 * is enabled in the configs.
	 *
	 * @return void
	 */
	private function loadMigrations() {
		if(config('app.user-login.migration', true)) {
			$this->loadMigrationsFrom(__DIR__.'/Migrations') ;
		}
	}

}
