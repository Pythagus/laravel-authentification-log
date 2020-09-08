<?php

namespace Pythagus\LaravelAuthentificationLog\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Pythagus\LaravelAuthentificationLog\Models\UserLogin;

/**
 * Class AuthentificationListener
 * @package Pythagus\LaravelAuthentificationLog\Listeners
 *
 * @author: Damien MOLINA
 */
class AuthentificationListener implements ShouldQueue {

	/**
	 * Class of the UserLogin instance.
	 *
	 * @var string
	 */
	public static $class ;

	/**
	 * Handle the event.
	 *
	 * @param Login $event
	 * @return void
	 */
	public function handle(Login $event) {
		$class = $this->getClass() ;

		$instance = new $class ;
		$instance->fill(
			$this->getTreatment($event->user)
		) ;
		$instance->save() ;
	}

	/**
	 * Get the callable function to
	 * manage the user data.
	 *
	 * @param $user
	 * @return array
	 */
	private function getTreatment($user) {
		$class = $this->getClass() ;

		return $class::getDataFromUser($user) ;
	}

	/**
	 * Get the UserLogin class.
	 *
	 * @return string|UserLogin
	 */
	private function getClass() {
		if(is_null(static::$class)) {
			AuthentificationListener::setClass(UserLogin::class) ;
		}

		return AuthentificationListener::$class ;
	}

	/**
	 * Set the UserLogin class.
	 *
	 * @param string $class
	 */
	public static function setClass(string $class) {
		AuthentificationListener::$class = $class ;
	}

}
