<?php namespace KevBaldwyn\SentryAuth\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Sentry;

class User extends \Cartalyst\Sentry\Users\Eloquent\User implements UserInterface, RemindableInterface {
	
	
	public static function create(array $attributes) {
		return Sentry::getUserProvider()->create($attributes);
	}


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
			
	public function __call($method, $parameters) {
		$sentryUserProvider = Sentry::getUserProvider();
		if(method_exists($sentryUserProvider, $method)) {
			return call_user_func_array(array($sentryUserProvider, $method), $parameters);
		}
		
		return parent::__call($method, $parameters);
	}


	public static function __callStatic($method, $parameters) {
		$sentryUserProvider = Sentry::getUserProvider();
		if(method_exists($sentryUserProvider, $method)) {
			return call_user_func_array(array($sentryUserProvider, $method), $parameters);
		}
		return parent::__callStatic($method, $parameters);
	}
	
	
}