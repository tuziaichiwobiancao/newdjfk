<?php

function cli_server_start($hostname = 'localhost', $port = null, $router = 'router.php') {
	for ($attempt = 0; is_null($port) && $attempt < 5; $attempt++) {
		$randomPort = rand(8000, 16000);

		$fp = @fsockopen($hostname, $port);

		// If this doesn't connect the port is fine
		if (!is_resource($fp)) {
			$port = $randomPort;
			break;
		}

		fclose($fp);
	}

	if (is_null($port)) {
		return null;
	}

	$docRoot = __DIR__;

	$descriptorSpec = array(
		0 => STDIN,
		1 => STDOUT,
		2 => STDERR,
	);

	$cmd = sprintf(
		'%s -t %s -n -S %s:%s %s',
		PHP_BINARY,
		$docRoot,
		$hostname,
		$port,
		$router
	);

	if (substr(PHP_OS, 0, 3) == 'WIN') {
		$handle = proc_open(addslashes($cmd), $descriptorSpec, $pipes, $docRoot, NULL, array("bypass_shell" => true,  "suppress_errors" => true));
	} else {
		$handle = proc_open("exec {$cmd} 2>/dev/null >/dev/null", $descriptorSpec, $pipes, $docRoot);
	}

	// note: even when server prints 'Listening on localhost:1234...Press Ctrl-C to quit.'
	//       it might not be listening yet...need to wait until fsockopen() call returns
	$i = 0;
	while (($i++ < 30) && !is_resource($fp = @fsockopen($hostname, $port))) {
		usleep(10000);
	}

	if (is_resource($fp)) {
		fclose($fp);
	} else {
		return null;
	}

	register_shutdown_function(
		function($handle) {
			proc_terminate($handle);
		},
		$handle
	);

	// don't bother sleeping, server is already up
	// server can take a variable amount of time to be up, so just sleeping a guessed amount of time
	// does not work. this is why tests sometimes pass and sometimes fail. to get a reliable pass
	// sleeping doesn't work.
	return $hostname . ':' . $port;
}
