<?php
class Input {
	//checks if a field exist and returns true
	public static function exists($type = 'post') {
		switch ($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
				break;
			case 'get':
				return (!empty($_GET)) ? true : false;
				break;
			default:
				return false;
				break;
		}
	}

	//gets a particular item from the register form
	public static function get($item) {
		if(isset($_POST[$item])) {
			return self::test_input($_POST[$item]);
		} else if(isset($_GET[$item])) {
			return self::test_input($_GET[$item]);
		}	
		return '';
	}

	public static function test_input($data) {
		if(!is_array($data)){
			$data = trim($data);
			$data = stripslashes($data);
			$data = strip_tags($data);
			$data = htmlspecialchars($data);
			return $data;
		} else {
			foreach ($data as $value) {
				$value = trim($value);
				$value = stripslashes($value);
				$value = strip_tags($value);
				$value = htmlspecialchars($value);
			}
			return $data;
		}

	}

}