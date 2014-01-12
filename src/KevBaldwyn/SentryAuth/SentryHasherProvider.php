<?php namespace KevBaldwyn\SentryAuth;


class SentryHasherProvider implements \Cartalyst\Sentry\Hashing\HasherInterface {
	
	protected $hasher;
	
	
	public function __construct(\Illuminate\Hashing\HasherInterface $hasher) {
		$this->hasher = $hasher;
	}
	
	
	/**
	 * Hash string.
	 *
	 * @param  string  $string
	 * @return string
	 */
	public function hash($string) {
		return $this->hasher->make($string);
	}


	/**
	 * Check string against hashed string.
	 *
	 * @param  string  $string
	 * @param  string  $hashedString
	 * @return bool
	 */
	public function checkhash($string, $hashedString){
		return $this->hasher->check($string, $hashedString);
	}
	
	
}