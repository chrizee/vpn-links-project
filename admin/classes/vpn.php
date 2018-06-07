<?php 

class Vpn extends Action {

	protected $_table = "vpn";

	public function add() {
        $fileUrl = (!empty($_FILES['file'])) ? $this->moveConfigFile('file') : '';
		$this->create([
			'url' => Input::get('url'),
			'username' => Input::get('username'),
			'password' => Input::get('password'),
            'server_name' => (!empty(Input::get('name'))) ? Input::get('name') :'',
		    'country' => (!empty(Input::get('country'))) ? Input::get('country'): '',
            'file_url' => $fileUrl,
			]);
	}

    public function moveConfigFile($name)
    {
        $nameToStore = uniqid().$_FILES[$name]['name'];
        $path = "config_files/";		//specifies the path to save the pic in
        if($dir = opendir($path)) {			//checks if the dir exist by opening it
            closedir($dir);			//if the dir exist ie opens successfully,close it
        } else {
            $dir = "config_files";
            mkdir($dir);				//if the dir doesn't exist create it inside the pic folder
        }

        $filename = $path.$nameToStore;
        if(move_uploaded_file($_FILES[$name]['tmp_name'], $filename)){
            return $filename;
        }
        return false;
    }

    public function edit() {
        if(!empty($_FILES['file']['name'])) {
            $fileUrl = $this->moveConfigFile('file');
            $this->update(Input::get('id'), [
                'url' => Input::get('url'),
                'username' => Input::get('username'),
                'password' => Input::get('password'),
                'server_name' => (!empty(Input::get('name'))) ? Input::get('name') : '',
                'country' => (!empty(Input::get('country'))) ? Input::get('country') : '',
                'file_url' => $fileUrl,
            ]);
        }else {
            $this->update(Input::get('id'), [
                'url' => Input::get('url'),
                'username' => Input::get('username'),
                'password' => Input::get('password'),
                'server_name' => (!empty(Input::get('name'))) ? Input::get('name') : '',
                'country' => (!empty(Input::get('country'))) ? Input::get('country') : '',
            ]);
        }
	}

	public function getTotal() {
		$sql = "SELECT COUNT(id) as total FROM vpn WHERE status =". Config::get('status/active');
        if (!$data = DB::getInstance()->query($sql)) {
            throw new PDOException("There was a problem getting total record");
        }
        return $data->first()->total;
	}

}