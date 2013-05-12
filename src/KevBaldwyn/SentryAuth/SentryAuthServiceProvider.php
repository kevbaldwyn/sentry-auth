<?php namespace KevBaldwyn\SentryAuth;

use Cartalyst\Sentry\Sessions\IlluminateSession;
use Illuminate\Support\ServiceProvider;

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

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
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

}