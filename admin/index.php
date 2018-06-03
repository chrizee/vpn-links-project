<?php
	require_once 'core/init.php';
	//Redirect::to('dashboard.php');
	//require_once 'Routes.php';
    //static $errors = [];
	$route = new Routes();
    $vpnObj = new Vpn();
	$route->add('/');
	$route->add('/logout');
	$route->add('/register');
	$route->add('/adduser');
	$route->add('profile');
	$route->add('updateuser');
	$route->add('/login');
	$route->add('/dashboard');
    $route->add('/addvpn');
    $route->add('/profile');
    $route->add('/editvpn');
    $route->add('/deletevpn');
	$query = $route->submit();
	$Qstring = '';
	if(!empty($query[1])) $Qstring = html_entity_decode($query[1]);
	if(file_exists($query[0].'.php')) {
		require_once($query[0].'.php');
	} else{
		require_once('includes/errors/404.php');
	}