<?php
class Session {
	//checks if a particular session exist
	public static function exists($name) {
		return (@isset($_SESSION[$name])) ? true : false;
	}

	//creates a session for the token
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

	//gets the session value
	public static function get($name) {
		return $_SESSION[$name];
	} 

	//checks if a token exists and deletes it
	public static function delete($name) {
		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}

	//sets message to be displayed after registration and makes sure messages displays only once. after reload it disappaers
	public static function flash($name, $string = '') {
		if(self::exists($name)) {
			$session = self::get($name); 
			self::delete($name);
			return $session;
		} else {
			self::put($name, $string);
		}
	}
}