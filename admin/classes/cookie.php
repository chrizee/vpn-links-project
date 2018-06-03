<?php
	class Cookie {
		//checks if a cookie exists
		public static function exists($name) {
			return (isset($_COOKIE[$name])) ? true : false;
		}

		//gets the value of the cookie
		public static function get($name) {
			return $_COOKIE[$name];
		}

		//sets the cookie for the remember me functionality
		public static function put($name, $value, $expiry) {
			if (setcookie($name, $value, time() + $expiry, '/')) {
				return true;
			}
			return false;
		}

		//deletes the cookie by setting it to null  and expiry to passed time
		public static function delete($name) {
			//self::put($name, '', time() - 1);
			setcookie($name, '', time() - 3600, '/');
		}
	}