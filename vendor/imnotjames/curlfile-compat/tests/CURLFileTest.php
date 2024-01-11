<?php

class CURLFileTest extends PHPUnit_Framework_TestCase {
	public function testCURLFileProperties() {
		$curlFile = new imnotjames\CURLFile('foo', 'bar', 'baz');

		$this->assertEquals('foo', $curlFile->name);
		$this->assertEquals('bar', $curlFile->mime);
		$this->assertEquals('baz', $curlFile->postname);

		$curlFile->setMimeType('foo');
		$curlFile->setPostFilename('oof');

		$this->assertEquals('foo', $curlFile->mime);
		$this->assertEquals('oof', $curlFile->postname);
	}

	public function testCURLFileToString() {
		$curlFile = new imnotjames\CURLFile('foo', 'bar', 'baz');

		$this->assertEquals(
			'@foo;filename=baz;type=bar',
			(string) $curlFile
		);
	}
}
