<?php

$start = microtime(true);

$basic_user = $_SERVER["PHP_AUTH_USER"];
$basic_pass = $_SERVER["PHP_AUTH_PW"];
$client_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
$req_scheme = $_SERVER["HTTP_X_FORWARDED_PROTO"];
$req_host = $_SERVER["HTTP_X_FORWARDED_HOST"];
$req_path = $_SERVER["HTTP_X_FORWARDED_URI"];
$req_url = $req_scheme . "://" . $req_host . $req_path;

json_encode($_SERVER);

$client_address_obj = \IPLib\Range\Single::fromString($client_address);

if ($debug === true) {
    header("HTTP/1.1 403 Forbidden");
    var_dump($fullrequest);
    exit;
}

?>