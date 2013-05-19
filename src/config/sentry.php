<?php
/**
 * overwrite default sentry configurations here
 */

return array(


	/*
	|--------------------------------------------------------------------------
	| Users
	|--------------------------------------------------------------------------
	|
	| Configuration specific to the user management component of Sentry.
	|
	*/
	'users' => array(

		/*
		|--------------------------------------------------------------------------
		| Model
		|--------------------------------------------------------------------------
		|
		| When using the "eloquent" driver, we need to know which
		| Eloquent models should be used throughout Sentry.
		|
		*/

		'model' => 'KevBaldwyn\SentryAuth\Models\User'
		
	),

	/*
	|--------------------------------------------------------------------------
	| Groups
	|--------------------------------------------------------------------------
	|
	| Configuration specific to the group management component of Sentry.
	|
	*/
	
	'groups' => array(

		/*
		|--------------------------------------------------------------------------
		| Model
		|--------------------------------------------------------------------------
		|
		| When using the "eloquent" driver, we need to know which
		| Eloquent models should be used throughout Sentry.
		|
		*/

		'model' => 'KevBaldwyn\SentryAuth\Models\Group',

	)
	
);