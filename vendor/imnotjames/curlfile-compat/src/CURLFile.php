<?php

if (!class_exists('CURLFile')) {
	class CURLFile extends imnotjames\CURLFile {}
}

if (!function_exists('curl_file_create')) {
	function curl_file_create($filename, $mimetype = null, $postname = null) {
		return new CURLFile($filename, $mimetype, $postname);
	}
}
