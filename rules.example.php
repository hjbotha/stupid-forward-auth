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
// allow(str $log_reason)
// block(str $log_reason, str $feedback)
// Allow or block the request matching the rule you provided.
// $log_reason: optional. String which may be logged to indicate which rule matched if $log_matches is true.
// $feedback: optional. Additional text to be sent to the requesting client (browser)

// Allow the request if it comes from an allowed network. See IP-Lib documentation for more valid IP address formats.
if (\IPLib\Factory::rangeFromString('fdaa:4f1c:17db::/48')->containsRange($client_address_obj)) allow("in IPv6 LAN");
if (\IPLib\Factory::rangeFromString('192.168.1.*')->containsRange($client_address_obj)) allow("Allow 192.168.1.x");
if (\IPLib\Factory::rangeFromString('192.168.15.0/24')->containsRange($client_address_obj)) allow("Allow 192.168.15.x");

// alice may only access 2 particular hosts
if (($basic_user === "alice") && ($basic_pass === "alice's password")) {
    if ($req_host === "app-alice-uses.example.com") allow("Alice allowed to access the app she uses");
    if ($req_host === "other-app-alice-uses.example.com") allow("Alice allowed to access the other app she uses");
}

// An example of basic authentication and a block rule. 
if (($basic_user === "default_user") && ($basic_pass === "weak_password")) block("Basic auth and block example");

// Provide feedback if user enters the right username but wrong password. Bob is only allowed to access one specific url though.
if (($basic_user === "bob") {
    if ($basic_pass === "bob's password")) {
        if ($req_url === "https://bob.example.com/bobscat.jpg") {
            allow("Bob's allowed to look at his cat");
        }
    } else {
        block($log_reason = "Wrong password for Bob", $feedback = "Wrong password, Bob.");
    }
}

// Regex and exact URL matching
if (preg_match("^https://homeassistant.example.com/api/webhook/.*",$req_path) === 1) allow("Home Assistant API call");
if ("^https://homeassistant.example.com/api/webhook" === $req_path) allow("Home Assistant API call root");

if (preg_match("^https://nas.example.com/sharing/.*",$req_url) === 1) allow("Synology sharing URL");



// If all rules have been evaluated and none matched, the following happens:
// - The response is set to 403 Forbidden
// - An Access Denied message is sent to the requesting client
// - The contents of the $feedback variable is sent to the requesting client
//   Placing additional information, such as $client_address in the $feedback variable
//     is useful for troubleshooting. Especially with IPv6, requests may not be coming
//     from the address you expect.
//     Append text to $feedback with .=
//     Newlines ("\n") will be converted to <br/> tags

//$feedback .= "Client IP Address: " . $client_address;
//$feedback .= "\n";

block("No rule matched, blocking by default", $feedback);

exit;

?>