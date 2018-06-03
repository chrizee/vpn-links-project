<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/init.php';

$app = new \Slim\App;

require_once '../src/routes/vpn.php';
$app->run();