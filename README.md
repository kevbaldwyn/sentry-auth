# Introduction
Sentry Auth is designed to be a drop in replacement for the native Laravel Auth system. It provides the same native API as the Auth class but also adds Sentry's own API to it natively. It also binds the Sentry User and Group model APIs to your Eloquent Model, along with mapping the Laravel Hash API to Sentry's. 

## Installation
Add the following to your composer.json file

    "repositories": [
        {
        	"type":"composer",
	        "url" : "http://packages.purepixel.co.uk"
        }
    ]

And the requirement

    "kevbaldwyn/sentry-auth":"dev-master"

Then `composer update`

## Configuration
The package users a couple of config options to bind the User and Group Models becuase it uses another of my packages "Avid" for extra model functionality. You can use Sentry Auth without this if you like by changing the Model Config:

sentry-auth/src/config/sentry.php

	'users' => array(

		'model' => 'KevBaldwyn\SentryAuth\Models\User'

	)

This can be changed to any model that extends `\Cartalyst\Sentry\Users\Eloquent\User`

sentry-auth/src/config/sentry.php can be used to overwrite any sentry default config options by defining any sentry config options with the same keys as you'd find in cartalyst/sentry/src/config/config.php

## Examples
You can use all native Auth class methods the same way plus additionally you can call Sentry methods natively from the same Auth API

    $user = Auth::register(array(
        'email'    => 'john.doe@example.com',
        'password' => 'test',
    ));
    // user will be an Eloquent Model with access to all of Sentry's user API
    $activationCode = $user->getActivationCode();
    var_dump($activationCode);
    
    Auth::loginUsingId(1);
    var_dump(Auth::user()->email);
    
    
    $credentials = array(
        'email'    => 'john.doe@example.com',
        'password' => 'test',
    );
    Auth::once($credentials);
    
    
    // Sentry User methods mapped directly to Eloquent model
    User::findByCredentials(array(
    	    'email'      => 'john.doe@example.com',
    	    'password'   => 'test')
    );
    
    // group model is not yet done 
    //$group = Group::create();
    $group = Sentry::getGroupProvider()->create(array(
        'name'        => 'Users',
        'permissions' => array(
            'admin' => 1,
            'users' => 1,
        ),
    ));
    
    
    $user = User::create(array(
        'email'    => 'john.doe@example.com',
        'password' => 'test',
    ));
    
    // Assign the group to the user
    $user->addGroup($group);