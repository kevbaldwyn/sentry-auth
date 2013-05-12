<?php namespace KevBaldwyn\SentryAuth;

use Illuminate\Auth\UserProviderInterface;
use Illuminate\Auth\UserInterface;
use Cartalyst\Sentry\Hashing\HasherInterface;
use Sentry;

class SentryUserProvider implements UserProviderInterface {
	
	
	protected $hasher;
	
	
	public function __construct(HasherInterface $hasher) {
		$this->hasher = $hasher;
	}
	

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed  $identifier
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveByID($identifier) {
		return Sentry::getUserProvider()->findById($identifier);
	}

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveByCredentials(array $credentials){
		return Sentry::getUserProvider()->findByCredentials($credentials);
	}

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Auth\UserInterface  $user
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validateCredentials(UserInterface $user, array $credentials){
		return $this->hasher->checkhash($credentials['password'], $user->getAuthPassword());
	}
	
	
}