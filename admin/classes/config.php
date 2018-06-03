<?php
class Config {
	public static function get($path = null ){
		if($path) {
			$config = $GLOBALS['config'];
			//creates an array to loop through
			$path = explode('/', $path); 

			foreach ($path as $bit) {
				if(isset($config[$bit])) {
					//sets congif to the current array to search it
					$config = $config[$bit];
				}
			}

			return $config;
		}
		return false;
	}
}