<?php

namespace Pythagus\LaravelAuthentificationLog\Listeners;

use Exception;
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
	 * Handle the event.
	 *
	 * @param Login $event
	 * @return void
	 * @throws Exception
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
	 * @throws Exception
	 */
	private function getTreatment($user) {
		$class = $this->getClass() ;

		return $class::getDataFromUser($user) ;
	}

	/**
	 * Get the UserLogin class.
	 *
	 * @return string|UserLogin
	 * @throws Exception
	 */
	private function getClass() {
		$class = config('app.user-login.model', UserLogin::class) ;

		if(! ($class instanceof UserLogin)) {
			throw new Exception("$class model should extend ".UserLogin::class) ;
		}

		return $class ;
	}

}
