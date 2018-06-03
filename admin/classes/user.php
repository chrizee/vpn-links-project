<?php
class User {
	protected $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn,
			$_staffs,
			$_errors = array(),
			$_table = 'users';

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
		//get the name of the session for the user
		$this->_sessionName = Config::get('session/session_admin');
		$this->_cookieName = Config::get('cookie/remember');
		if(!$user) {
			if(Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					//process logout.
				}
			}
		} else {
			$this->find($user);
		}
	}

	//method to update users information
	public function update($fields= array(), $id = null, $table = null,$key = 'id' ) {
		//sets the id to update to that of the logged in user
		if(!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}
		if(!$table) {
			$table = $this->_table;
		}
		if(!$this->_db->update($table, $id, $fields, $key)) {
			throw new Exception("There was a problem updating");
		}
	}

	//creates a user and insert values into database
	public function create($fields = array(), $table = null) {
		if(!$table) {
			$table= $this->_table;
		}
		if(!$this->_db->insert($table, $fields)) {
			throw new Exception("There was a problem creating that account");
		}
	}

	//finds a user and returns the first result from the user table
	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'email';
			$data = $this->_db->get($this->_table, array($field, '=', $user));	//holds the result returned fron the database when loggin in

			if($data && $data->count()) {
				$this->_data = $data->first();
				return true;
			}
		} 
		return false;	
	}


	//log a user in and sets a session->user to the id of the user
	public function login($email = null, $password = null, $remember = false) {
		
		//checks if no data has been passed to login and if an user data is available
		//user data is available if exists() returns true ie _data has value
		if(!$email && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			//logs user in by finding the user data in the database with email
			$user = $this->find($email);	
			if($user) {
				//if user exist check the password supplied with the stored password and log the user in
				if($this->data()->password === Hash::make($password,$this->data()->salt)) {
					if($this->data()->status == 1) {
						//creates a session if the password checking passes
						Session::put($this->_sessionName, $this->data()->id);

						if($remember) {
							$hash = Hash::unique();
							$hashCheck  = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
							//if user has not been remembered before,remember user by storing the hash in the database
							if(!$hashCheck->count()) {
								$this->_db->insert('users_session', array(
									'user_id' => $this->data()->id,
									'hash' => $hash
								));
							} else {
								//else get the hash from the database and save it as a cookie in the browser
								$hash = $hashCheck->first()->hash;
							}
							//sets cookie if user asks to be remembered
							Cookie::put($this->_cookieName, $hash, Config::get('cookie/expiry_one_week'));
						}
						return true;
					} else {
						$this->addError('You are no longer an active member. Contact the admin for more info.');
					}
				} else {
					$this->addError('wrong password');
				}
			} else {
				$this->addError('Email does not exist');
			}
		}
		return false;
	}

	//checks if a user is an admin and returns true to use in the pages
	public function hasPermission($key) {
		//gets the group of the user from the groups table using the groups column in the user table
		$group = $this->_db->get('groups', array('id', '=', $this->data()->groups));
		if($group->count()) {
			//decode the permission to an array from json 
			$permissions = json_decode($group->first()->permissions, true);

			//checks if the flag is set to 1 or true
			if(array_key_exists($key, $permissions) && $permissions[$key] == true) {
				return true;
			}
		}
		return false;
	}

	public function getStaffs($where = array()) {
		if(!$this->_staffs = $this->_db->get($this->_table, $where)) {
			throw new Exception("Error getting staffs");
		} else {
			return $this->_staffs->results();
		}
	}

	public function getStaffEmail($where = array()) {
		if(count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=');

			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];

			if(in_array($operator, $operators)) {
				$sql = "SELECT email FROM $this->_table WHERE {$field} {$operator} ?";
				if($email = $this->_db->query($sql,array($value))) {
					return $email->results();
				}
			}	
		}
		return false;
	}

	public function deleteStaff($where = array()) {
		if(!$this->_db->delete($this->_table, $where)) {
			throw new Exception("Error deleting Staff");
		}
	}

	public function getNextId() {
		$sql = "SELECT MAX(id) AS id  FROM {$this->_table}";	//gets the highest id from the specified table to name the new product
		$data = $this->_db->query($sql);
		if($data->count()) {
			$id = $data->first()->id;
			return ++$id;						//adds 1 to the returned value to get the new name
		}
		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}  
	//logs out a user by delettin the session created when the user logged in
	public function logout() {
		Session::delete($this->_sessionName);
		if(Cookie::exists($this->_cookieName)) {
			Cookie::delete($this->_cookieName);
			$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
		}
	}

	public function data() {
		return $this->_data; 
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}
	//method to move uploaded to final folder
	public function movePic($pic) {
		$name = uniqid(). ".jpg";					
		$path = "img/users/";		//specifies the path to save the pic in
		if($dir = opendir($path)) {			//checks if the dir exist by opening it
			closedir($dir);			//if the dir exist ie opens successfully,close it
		} else {
			$dir = "img/users";
			mkdir($dir);				//if the dir doesn't exist create it inside the pic folder
		}

		$filename = $path.$name;
		if(move_uploaded_file($_FILES[$pic]['tmp_name'], $filename)){
			return $name;
		}
			return false;
	}
	
}