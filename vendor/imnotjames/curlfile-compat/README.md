# CURLFile Compatibility Library

[![Build Status](https://travis-ci.org/imnotjames/curlfile-compat.svg?branch=master)](https://travis-ci.org/imnotjames/curlfile-compat)
[![Coverage Status](https://img.shields.io/coveralls/imnotjames/curlfile-compat.svg)](https://coveralls.io/r/imnotjames/curlfile-compat)

Compatibility library to add a [CURLFile](http://php.net/class.curlfile) class to older versions of PHP.
[https://wiki.php.net/rfc/curl-file-upload](The RFC) has some more information on it as well.


This class abuses the fact that the PHP `CURLOPT_POSTFIELDS` option will coerce classes to strings when
sending it as data, and outputs the older style of including files in the post data.

## Installation

New school or old school, your choice.

For a new school installation with [Composer](http://getcomposer.org) simply [add it to your list of dependencies.](https://packagist.org/packages/imnotjames/curlfile-compat)

If you're kicking it old school you've got to `require` `src/CURLFile.php` and `src/imnotjames/CURLFILE.php`.

Either way, the non-namespaced CURLFile will only be created if the class doesn't already exist.  Same goes for the `create_curl_file` function.


## Usage

Exactly the same as [PHP's CURLFile'](http://php.net/curlfile)

```php
$handle = curl_init('http://example.com');

$cfile = new CURLFile('puppy.jpg','image/jpeg','puppy_boquet');

// Assign POST data
$data = array('test_file' => $cfile);

curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

curl_exec($handle);
```
