<?php

// This is where you'll define the rules for allowing/blocking requests. Your available variables are:
// $basic_user: Username sent using basic authentication, if any
// $basic_pass: Password sent using basic authentication, if any
// $client_address: IP address of the client. May be IPv4 or IPv6.
// $client_address_obj: IP address of the client in object form, i.e. a format that ip-lib can understand.
// $req_scheme = Protocol used, http, https, etc.
// $req_host: The requested server hostname (the Host header in an HTTP request)
// $req_path: The bit after the host, e.g. "/website/index.html"
// $req_url: The last 3 things joined together in a string
// $fullrequest: ALL the details of the request, in JSON format

// functions:
// allow(str $reason, str $additionaldata)
// block(str $reason, str $additionaldata)
// Allow or block the request matching the rule you provided.
// $reason: optional. String which may be logged to indicate which rule matched.

// Print the execution time to the log after every request
$time_execution = false;

// Log debug messages
$debug = true;

// Allow the request if it comes from an allowed network. See IP-Lib documentation for more valid IP address formats.
if (\IPLib\Factory::rangeFromString('fdaa:4f1c:17db::/48')->containsRange($client_address_obj)) allow("in IPv6 LAN");
if (\IPLib\Factory::rangeFromString('192.168.1.*')->containsRange($client_address_obj)) allow("Allow 192.168.1.x");
if (\IPLib\Factory::rangeFromString('192.168.15.0/24')->containsRange($client_address_obj)) allow("Allow 192.168.15.x");



// An example of basic authentication and a block rule. 
if (($basic_user === "default_user") && ($basic_pass === "weak_password")) block("Weak password");

// Regex and exact URL matching
if (preg_match("^https://homeassistant.example.com/api/webhook/.*",$req_path) === 1) allow("Home Assistant API call");
if ("^https://homeassistant.example.com/api/webhook" === $req_path) allow("Home Assistant API call root");

if (preg_match("^https://nas.example.com/sharing/.*",$req_url) === 1) allow("Synology sharing URL");



// Stop editing here

?>