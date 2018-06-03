<?php
ini_set("display_errors", 'on');

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'christo16',
        'db' => 'vpn'
    ),
    'status' => array(
        'deleted' => 0,
        'active' => 1,
    )
);

spl_autoload_register(function($class) {
    require_once '../../admin/classes/' . $class . '.php';	//requires a class only when needed
}
);
require_once '../../admin/functions/sanitize.php'; //includes the function file