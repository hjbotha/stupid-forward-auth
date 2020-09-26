<?php

// Print the execution time to the log after every request
$time_execution = false;

// Log reasons to web server log when calling allow() and block()
$log_matches = true;

// Reject requests and output full request details in response.
// Potentially dangerous. Exposes internal host names and IP addresses.
// Don't leave enabled for too long and preferably not at all when exposed to internet.
$debug = false;

?>