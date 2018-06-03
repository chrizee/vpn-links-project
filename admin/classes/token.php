<?php
class Token {
	//generates a unique token for each load of the page
	public static function generate() {
		return Session::put(Config::get('session/token_name'),md5(uniqid())); 
	}

	//checks if a session exist and matches the token generated for the session
	public static function check($token) {
		$tokenName = Config::get('session/token_name');

		if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}

		return false;
	}
}