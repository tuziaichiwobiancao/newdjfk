<?php
namespace imnotjames;

/**
 * Adds a compatibility class for older versions of PHP.
 *
 * This abuses the fact that objects are coerced to being strings
 * in CURL when passed as a post field.  This also will only work with
 * safe upload off - but seeing as it's for PHP <5.5 that shouldn't be
 * an issue.
 */
class CURLFile {
	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $mime;

	/**
	 * @var string
	 */
	public $postname;

	/**
	 * Create CurlFile object
	 *
	 * @param string $name File name
	 * @param string $mimetype Mime type, optional
	 * @param string $postfilename Post filename, defaults to actual filename
	 */
	public function __construct($name, $mime = '', $postname = '') {
		$this->name = $name;
		$this->mime = $mime;
		$this->postname = $postname;

	}

	/**
	 * Get file name from which the data will be read
	 *
	 * @return string
	 */
	public function getFilename() {
		return (string) $this->name;
	}

	/**
	 * Get mime type
	 *
	 * @param string $mime
	 */
	public function setMimeType($mime) {
		$this->mime = $mime;
	}

	/**
	 * Set mime type
	 *
	 * @return string
	 */
	public function getMimeType() {
		return (string) $this->mime;
	}

	/**
	 * Set file name which will be sent in the post
	 *
	 * @param string $postname
	 */
	public function setPostFilename($postname) {
		$this->postname = $postname;
	}

	/**
	 * Get file name which will be sent in the post
	 *
	 * @return string
	 */
	public function getPostFilename() {
		return (string) $this->postname;
	}

	public function __toString() {
		$filename = $this->getFilename();
		$mimetype = $this->getMimeType();
		$postname = $this->getPostFilename();

		$output = '@' . $filename;

		if (!empty($postname)) {
			$output .= ';filename=' . $postname;
		}

		if (!empty($mimetype)) {
			$output .= ';type=' . $mimetype;
		}

		return $output;
	}
}
