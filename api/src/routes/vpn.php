<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//get all vpns
$app->get('/vpn', function(Request $request, Response $response) {
    try {
        $vpnObj = new Vpn();
        $vpns = $vpnObj->get(['status', '=', Config::get('status/active')]);
        echo json_encode($vpns);
    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'} }';
    }
});