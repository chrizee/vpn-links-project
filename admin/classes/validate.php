<?php
class Validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct () {
		$this->_db = DB::getInstance();
	}

	public function __destruct() {
		$this->_db = null;
	}
	//checks if all fields validate by looping thru each field
	//and checking validation rule in object call
	public function check($sources, $items = array()) {
		foreach($items as $item => $rules) {
			$sources[$item] = Input::test_input(($sources[$item]));
			foreach($rules as $rule => $rule_value) {
				//removes spaces to validate against min and max and removes suspicious characters 
				$value = $sources[$item];
				$item = escape($item);

				//sets error if the field is required 
				if($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required");
				} else if(!empty($value)) {
					//switch thru each rule ste in object
					switch ($rule) {
						case 'min':
							if (strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value} characters.");
							}
						break;
						case 'max':
							if (strlen($value) > $rule_value){
								$this->addError("{$item} must be a maximum of {$rule_value} characters.");
							}
						break;
						case 'matches':
							if($value != $sources[$rule_value]) {
								$this->addError("{$rule_value} must match {$item}");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()) {
								$this->addError("{$item} already exist");
							}
						break;
						case 'numeric';
							if(!is_numeric($value) || $value <= $rule_value) {
								$this->addError("{$item} must be numeric and greater than $rule_value");
							}
						break;
						case 'integer';
							if(!is_integer($value) || $value <= $rule_value) {
								$this->addError("{$item} must be integer and greater than $rule_value");
							}
						break;
                        case 'int';
                            if(!is_integer($value)) {
                                $this->addError("{$item} must be integer");
                            }
                            break;
                        case 'float';
                            if(!is_float($value)) {
                                $this->addError("{$item} must be a valid decimal value");
                            }
                            break;
						case 'date';
							$dateArray = explode("-", $value);
							if (!checkdate($dateArray[1], $dateArray[2], $dateArray[0])) {	//format passed by date input type is yyyy/mm/dd
								$this->addError('date must be in yyyy-mm-dd format');
							}
						break;
						case 'function':
							$this->$rule_value($value);
						break;

					}
				}
			}
		}
		//sets _passed to true if no error is set
		if(empty($this->_errors)) {
			$this->_passed = true;
		} else {
			$this->_passed = false;
		}
		return $this;
	}

	//method to add message to the errors array
	public function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	//method to check if validation passes bychecking if _passed if true
	public function passed() {
		return $this->_passed;
	}

	private function checkPhone($phone) {
	    //Checking if number starts with 080, 090, 070 and 081
	    if(!preg_match('/^\d{11}$/', $phone) or (!preg_match('/^080/', $phone) and !preg_match('/^070/', $phone) and !preg_match('/^090/', $phone) and !preg_match('/^081/', $phone))) {
	    	$this->addError("$phone must be a valid Nigerian number");
	        return false;
	    }
	    //Every requirements are made
	    else {
	        return true;
	    }
	}

	private function checkEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {	//allow only a valid email
	      	$this->addError('email is not valid');
	      	return false;
	   	}
	   	return true; 
	}
	
	private function checkDate($date) {
		if(substr_count($date, '-', 4) == 2) {
			$arr = explode('-', $date);
			$year = $arr[0];
			$month = $arr[1];
			$day = $arr[2];
			if(!checkdate($month, $day, $year)) {
				$this->addError("please date format is yyyy-mm-dd");
			}
		} else {
			$this->addError("please date format is yyyy-mm-dd");
		}
	}

	private function checkDateAgainstNow($date) {
		self::checkDate($date);
		$now = new dateTime();
		$entered = new dateTime($date);
		if($now > $entered) {
			$this->addError("Date must be in the past");
		}
	}
	//validation method for pictures.
	public function checkPic($pic) {		
		if ($_FILES[$pic]["error"] == UPLOAD_ERR_OK and !empty($_FILES[$pic]) ) {
			
			if (!in_array($_FILES[$pic]["type"], Config::get('cards/formats'))) {
				$this->addError("jpeg/jpg/png/gif photos only");
			}
			if ($_FILES[$pic]["size"] > Config::get('cards/max_size') ) {
				$this->addError("Photo size must be less than 1MB");		
			}
		} else {
			switch( $_FILES[$pic]["error"] ) {
				case UPLOAD_ERR_INI_SIZE:
					$this->addError("The photo is larger than the server allows.");
				break;
				case UPLOAD_ERR_FORM_SIZE:
					$this->addError("The photo is larger than the script allows.");
				break;
				case UPLOAD_ERR_NO_FILE:
					$this->addError("No file was uploaded. Make sure you choose a file to upload.");
				break;
			}
			
		}
		if(empty($this->_errors)) {
			$this->_passed = true;
		} else {
			$this->_passed = false;
		}
		return $this;
	}

    public function checkPic2($pic) {
        if ($_FILES[$pic]["error"] == UPLOAD_ERR_OK and !empty($_FILES[$pic]) ) {

            if (!in_array($_FILES[$pic]["type"], Config::get('cards/formats'))) {
                $this->addError("jpeg/jpg/png/gif photos only");
            }
            if ($_FILES[$pic]["size"] > Config::get('cards/max_size') ) {
                $this->addError("Photo size must be less than 1MB");
            }
        } else {
            switch( $_FILES[$pic]["error"] ) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->addError("The photo is larger than the server allows.");
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $this->addError("The photo is larger than the script allows.");
                    break;
            }

        }
        if(empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
        return $this;
    }

    public function checkConfigFile($file, $required = true) {
        if ($_FILES[$file]["error"] == UPLOAD_ERR_OK and !empty($_FILES[$file]) ) {

            if (!in_array($_FILES[$file]["type"], Config::get('app/vpn_file_type'))) {
                $this->addError(implode(Config::get('app/vpn_file_extension'))." formats only");
            }
            if ($_FILES[$file]["size"] > Config::get('app/max_file_size/vpn') ) {
                $this->addError("config file size must be less than". Config::get('app/max_file_size/vpn')."B");
            }
        } else {
            switch( $_FILES[$file]["error"] ) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->addError("The file is larger than the server allows.");
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $this->addError("The file is larger than the script allows.");
                    break;
                case UPLOAD_ERR_NO_FILE:
                    if(Config::get('app/vpn_file_required') && $required)
                        $this->addError("No file was uploaded. Make sure you choose a file to upload.");
                    break;
            }

        }
        if(empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
        return $this;
    }
}
