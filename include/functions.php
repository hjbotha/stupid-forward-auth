<?php

function allow(string $reason = null) {
	if ($reason) {
		log_match("Allowed: " . $reason);
	}
	exit;
}

function block(string $reason = null) {
	header("HTTP/1.1 403 Forbidden");
	if ($reason) {
		log_match("Blocked: " . $reason);
	}
	inform_client();
}

function inform_client() {
	echo("<H1>");
	echo("Forbidden");
	echo("</H1>");
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