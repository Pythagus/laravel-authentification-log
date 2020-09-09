<?php

namespace Pythagus\LaravelAuthentificationLog\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLogin
 * @package Pythagus\LaravelAuthentificationLog\Models
 *
 * @property int user_id
 *
 * @property Carbon created_at
 *
 * @author: Damien MOLINA
 */
class UserLogin extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'user_login' ;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'ip_addr'] ;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['created_at'] ;

	/**
	 * Get the authentification date.
	 *
	 * @return Carbon
	 */
	public function authAt() {
		return $this->created_at ;
	}

	/**
	 * Get the data from the given user.
	 *
	 * @param $user
	 * @return array
	 */
	public static function getDataFromUser($user) {
		return [
			'user_id' => $user->id,
			'ip_addr' => request()->ip(),
		] ;
	}

	/**
	 * Get the config at the given key.
	 *
	 * @param string $key
	 * @param $default
	 * @return mixed
	 */
	public static function config(string $key, $default = null) {
		return config('auth.user-login.'.$key, $default) ;
	}

}
