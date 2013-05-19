<?php namespace KevBaldwyn\SentryAuth\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Sentry;

class User extends \Cartalyst\Sentry\Users\Eloquent\User implements UserInterface, RemindableInterface {
	
	
	public function __construct(array $attributes = array()) {
		
		// define dependencies
		// this is for when we are calling the model directly
		// these are usually defined by the IoC however as we are effectively breaking this to provide a consistent API 
		// so we need to redefine them in the constructor
		// probably not the best approach...
		static::$hasher = \App::make('sentry.hasher');
		static::$loginAttribute = \Config::get('cartalyst/sentry::users.login_attribute');
		
		parent::__construct($attributes);
		
	}
	
	
	//protected static $hasher;

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