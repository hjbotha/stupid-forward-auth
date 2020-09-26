<?php

function allow(string $reason = null) {
	if ($reason) {
		log_match("Allowed: " . $reason);
	}
	exit;
}

function block(string $reason = null) {
	if ($reason) {
		log_match("Blocked: " . $reason);
	}
	reject_request();
}

function reject_request() {
	header("HTTP/1.1 403 Forbidden");
	echo("<H1>");
	echo("Forbidden");
	echo("</H1>");
	exit;
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