<?php

/**
 * @requires PHP 5.4
 */
class NamespacedCURLFileIntegrationTest extends PHPUnit_Framework_TestCase {
	private $handle;

	private $testFilename;

	public function setUp() {
		$this->testFilename = __DIR__ . '/fixtures/curl_testdata1.txt';

		include_once(__DIR__ . '/fixtures/server.inc');

		$host = cli_server_start();

		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, "http://{$host}/");
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

		// If safe upload is defined, disable it for this unit test (>= 5.5)
		// Also disable deprecated error reporting for now..
		if (defined('CURLOPT_SAFE_UPLOAD')) {
			curl_setopt($handle, CURLOPT_SAFE_UPLOAD, 0);
			error_reporting(E_ALL & ~E_DEPRECATED);
		}

		$this->handle = $handle;
	}

	public function tearDown() {
		curl_close($this->handle);
	}

	public function testCurlFileBasic() {
		$file = new imnotjames\CURLFile($this->testFilename);

		curl_setopt($this->handle, CURLOPT_POSTFIELDS, array('file' => $file));
		$output = curl_exec($this->handle);

		$this->assertEquals('curl_testdata1.txt|application/octet-stream|6', $output);
	}

	public function testCurlFileWithPostname() {
		$file = new imnotjames\CURLFile($this->testFilename);
		$file->setPostFilename('foo');

		curl_setopt($this->handle, CURLOPT_POSTFIELDS, array('file' => $file));
		$output = curl_exec($this->handle);

		$this->assertEquals('foo|application/octet-stream|6', $output);
	}

	public function testCurlFileWithMimeType() {
		$file = new imnotjames\CURLFile($this->testFilename);
		$file->setMimeType('text/plain');

		curl_setopt($this->handle, CURLOPT_POSTFIELDS, array('file' => $file));
		$output = curl_exec($this->handle);

		$this->assertEquals('curl_testdata1.txt|text/plain|6', $output);
	}

	public function testCurlFileWithMimeAndPostname() {
		$file = new imnotjames\CURLFile($this->testFilename);
		$file->setPostFilename('bar');
		$file->setMimeType('foo');

		curl_setopt($this->handle, CURLOPT_POSTFIELDS, array('file' => $file));
		$output = curl_exec($this->handle);

		$this->assertEquals('bar|foo|6', $output);
	}
}
