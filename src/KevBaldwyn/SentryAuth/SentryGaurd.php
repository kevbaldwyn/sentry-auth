<?php namespace KevBaldwyn\SentryAuth;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Guard;
use Illuminate\Auth\UserProviderInterface;
use Cartalyst\Sentry\Sessions\IlluminateSession;
use Sentry;
use Debugger;


// extends gaurd and maps any unknown requests to Sentry
// allows us to use the Auth interface and API transparently (hopefully!)
class SentryGaurd extends Guard {
	
	
	public function __construct(UserProviderInterface $provider,
							    IlluminateSession $session) {
		
		$this->provider = $provider;
		$this->session  = $session;
		
	}
	
	
	public function check() {
		return Sentry::check();
	}
	
	
	public function guest() {
		return (Sentry::check()) ? false : true;
	}
	
	
	public function user() {
		return Sentry::getUser();
	}
	
	
	public function getUser() {
		return static::user();
	}
	
	
	public function login(UserInterface $user, $remember = false) {
		Sentry::login($user, $remember);
	}
	
	
	public function loginUsingId($id, $remember = false) {
		$user = Sentry::getUserProvider()->findById($id);
		$this->login($user, $remember);
	}
	
	
	public function logout() {
		Sentry::logout();
	}
	
	
	/* Sentry specific methods */
	/*
	public function register(array $attributes) {
		return Sentry::register($attributes);
	}
	*/
	public function __call($method, $parameters) {
		
		$methodArray = array('Sentry', $method);
		
		if(is_callable($methodArray)) {
			return call_user_func_array(array('Sentry', $method), $parameters);
		}
		
		return parent::__call($method, $parameters);
	
	}
	
}



