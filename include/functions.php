<?php

function allow(string $log_reason = null) {
	if ($log_reason) {
		log_match("Allowed: " . $log_reason);
	}
	exit;
}

function block(string $log_reason = null, string $feedback = null) {
	header("HTTP/1.1 403 Forbidden");
	if ($log_reason) {
		log_match("Blocked: " . $log_reason);
	}
	header("HTTP/1.1 403 Forbidden"); // This should always be a 4xx status code. 2xx or 3xx would cause the request to be allowed.
	inform_client($feedback);
}

function inform_client(string $feedback = null) {
	echo("<H1>Forbidden</H1>");
	echo(nl2br($feedback));
}

function printExecutionTime($start, $time_execution = false)
{
	if ($time_execution == true) {
		$execution_time = microtime(true) - $start;
		log_match("Execution time: " . $execution_time . " s");
	}
}

function log_match($string) {
	if ($GLOBALS['log_matches'] === true) {
		error_log($string);
	}
}

?>