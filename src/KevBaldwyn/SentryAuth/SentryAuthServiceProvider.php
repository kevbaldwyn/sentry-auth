<?php namespace KevBaldwyn\SentryAuth;

use Cartalyst\Sentry\Sessions\IlluminateSession;
use Illuminate\Support\ServiceProvider;
use Config;
use Debugger;

class SentryAuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('kevbaldwyn/sentry-auth');

		$this->registerAuth();
		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->loadSentryConfig();
		
		$this->registerHasher();
		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}
	
	
	private function registerHasher() {
		
		$app = $this->app;		
		
		// redefine the sentry hasher to match laravel
		$this->app['sentry.hasher'] = $this->app->share(function($app) {
			return new SentryHasherProvider($app['hash']);
		});
		
	}
	
	
	private function registerAuth() {
		
		$app = $this->app;	
		
		// redefine the Auth instance within the app
		$this->app['auth']->extend('sentry', function() use ($app) {
			
			// we are re-defining the Auth facade as an instance of KevBaldwyn\SentryAuth\SentryGaurd which extends Illuminate\Auth\Gaurd (the default Auth)
		    return new SentryGaurd(
		    	
		    	// define our user provider as using sentry
		        new SentryUserProvider($app['sentry.hasher']),
		        
		        // define the Session instacne as the sentry one
		        $app['sentry.session']
		        
		    );
		});
		
	}
	
	
	
	
	private function loadSentryConfig() {
		
		Config::package('kevbaldwyn/sentry-auth', __DIR__.'/../../config');
		
		$this->recurseLoadConfig(Config::get('sentry-auth::sentry'));
	}
	
	
	private function recurseLoadConfig($config, $key = '') {
		foreach($config as $k => $v) {
			$thiskey =  $key . '.' . $k;
			if(is_array($v)) {
				$this->recurseLoadConfig($v, $thiskey);	
			}else{
				$thiskey = trim($thiskey, '.');
				$this->app['config']->set('cartalyst/sentry::'. $thiskey, $v);
			}
		}
	}

}