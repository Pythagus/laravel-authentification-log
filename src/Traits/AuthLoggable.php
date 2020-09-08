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
    public function lastLoginAtPosition(int $position = 0) {
        return $this->logins->skip($position)->first() ;
    }

}
