<?php 

class Vpn extends Action {

	protected $_table = "vpn";

	public function add() {
		$this->create([
			'url' => Input::get('url'),
			'username' => Input::get('username'),
			'password' => Input::get('password')
			]);
	}

	public function edit() {
		$this->update(Input::get('id'), [
			'url' => Input::get('url'),
			'username' => Input::get('username'),
			'password' => Input::get('password')
			]);
	}

	public function getTotal() {
		$sql = "SELECT COUNT(id) as total FROM vpn WHERE status =". Config::get('status/active');
        if (!$data = DB::getInstance()->query($sql)) {
            throw new PDOException("There was a problem getting total record");
        }
        return $data->first()->total;
	}

}