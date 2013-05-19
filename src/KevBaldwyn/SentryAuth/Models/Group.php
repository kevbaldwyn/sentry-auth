<?php namespace KevBaldwyn\SentryAuth\Models;

use Sentry;

class Group extends \Cartalyst\Sentry\Groups\Eloquent\Group {
		
			
	public function __call($method, $parameters) {
		$sentryGroupProvider = Sentry::getGroupProvider();
		if(method_exists($sentryGroupProvider, $method)) {
			return call_user_func_array(array($sentryGroupProvider, $method), $parameters);
		}
		
		return parent::__call($method, $parameters);
	}


	public static function __callStatic($method, $parameters) {
		$sentryGroupProvider = Sentry::getGroupProvider();
		if(method_exists($sentryGroupProvider, $method)) {
			return call_user_func_array(array($sentryGroupProvider, $method), $parameters);
		}
		return parent::__callStatic($method, $parameters);
	}
	
}
