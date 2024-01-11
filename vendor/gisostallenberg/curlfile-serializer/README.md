# CURLFileSerializer

Serialize and unserialize a CURLFile

## Installation
```bash
composer require gisostallenberg/curlfile-serializer
```

## Usage example
```php
<?php

use GisoStallenberg\CURLFileSerializer\CURLFileSerializer;

$curlFileSerializer = CURLFileSerializer::create(new CURLFile('/path/to/file.txt'));
$serialized = serialize($curlFileSerializer);

$curlFileSerializer = unserialize($serialized);
$curlFile = $curlFileSerializer->getCURLFile(); // Is an instanceof CURLFile
```