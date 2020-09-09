<?php

namespace Pythagus\LaravelAuthentificationLog\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pythagus\LaravelAuthentificationLog\Models\UserLogin;

/**
 * Trait AuthLoggable
 * @package Pythagus\LaravelAuthentificationLog\Traits
 *
 * @property Collection logins
 *
 * @author: Damien MOLINA
 */
trait AuthLoggable {

	/**
	 * Get all the user's logins.
	 *
	 * @return BelongsTo
	 */
	public function logins() {
		return $this->hasMany(UserLogin::class, 'user_id')->orderByDesc('created_at') ;
	}

	/**
	 * Get the last instance of user's login.
	 * We skip the first data because the last
	 * user's connection is before the last one.
	 *
	 * @return UserLogin|null
	 */
	public function lastLogin() {
		return $this->lastLoginAtPosition(1) ;
	}

	/**
	 * Get the last instance of user's login.
	 * We skip the first data because the last
	 * user's login is before the last one.
	 *
	 * @param int $position
	 * @return UserLogin
	 */
	public function lastLoginAtPosition(int $position = 1) {
		return $this->lastLoginScope($position)->first() ;
	}

	/**
	 * Determine whether the user already has
	 * a UserLogin instance at the given position.
	 *
	 * @param int $position
	 * @return bool
	 */
	public function hasLastLogin(int $position = 1) {
		return $this->lastLoginScope($position)->isNotEmpty() ;
	}

	/**
	 * Get the last login user date in the
	 * given format.
	 *
	 * @param string $format
	 * @param int $position
	 * @return string
	 */
	public function lastLoginAtFormat(string $format = 'Y-m-d H:i', int $position = 1) {
		/** @var UserLogin $login */
		$login = $this->lastLoginScope($position)->first() ;

		if($login) {
			return $login->authAt()->format($format) ;
		}

		return null ;
	}

	/**
	 * @param int $position
	 * @return Collection
	 */
	private function lastLoginScope(int $position) {
		return $this->logins->skip($position) ;
	}

}
