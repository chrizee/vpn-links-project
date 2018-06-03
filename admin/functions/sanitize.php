<?php
function escape($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
$key = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
function encode($data) {
	global $key;
	return base64_encode($data."::".$key);
}
function decode($data) {
	return explode("::", base64_decode($data), 2)[0];
}
