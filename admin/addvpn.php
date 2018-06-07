<?php
//require_once 'core/init.php';
if(Input::exists() && !empty(Input::get('vpn'))) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'url' => array(
            'required' => true,
            'max' => '50',
        ),
        'username' => array(
            'required' => true,
            'max' => 255
        ),
        'password' => array(
            'required' => true,
            'max' => 255
        ),
        'name' => array(
            'max' => 255
        ),
        'country' => array(
            'max' => 255
        )
    ));
    $validation->checkConfigFile('file');
    if ($validation->passed()) {
        try {
            $vpnObj->add();
            Session::flash('home',"VPN added successfully");
            Redirect::to("dashboard");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    } else {
        foreach ($validation->errors() as $key => $error) {
            Routes::$errors[] = $error;
        }
        Session::flash('errors', implode("::", Routes::$errors));
    }
}else {
    Session::flash('home', "Provide the required information correctly.");
}
//editing vpn
if(Input::exists() && !empty(Input::get('vpnEdit'))) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'url' => array(
            'required' => true,
            'max' => '50',
        ),
        'username' => array(
            'required' => true,
            'max' => 255
        ),
        'password' => array(
            'required' => true,
            'max' => 255
        ),
        'name' => array(
            'max' => 255
        ),
        'country' => array(
            'max' => 255
        )
    ));
    if(!empty($_FILES['file'])) $validation->checkConfigFile('file', false);
    if ($validation->passed()) {
        try {
            $vpnObj->edit();
            Session::flash('home', "VPN updated");
            Redirect::to("dashboard");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    } else {
        foreach ($validation->errors() as $key => $error) {
            Routes::$errors[] = $error;
        }
        Session::flash('errors', implode("::", Routes::$errors));
    }
}else {
    Session::flash('home', "Provide the required information correctly.");
}
Redirect::to("dashboard");