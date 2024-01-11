<?php

namespace GisoStallenberg\CURLFileSerializer;

use CURLFile;
use Serializable;
use UnexpectedValueException;

/**
 * A class to serialize a CURLFile object.
 */
class CURLFileSerializer implements Serializable
{
    /**
     * The curlfile.
     *
     * @var CURLFile
     */
    private $curlfile;

    /**
     * Create a new CURLFileSerializer class.
     *
     * @param CURLFile $curlfile
     */
    public function __construct(CURLFile $curlfile)
    {
        $this->curlfile = $curlfile;
    }
    /**
     * Create a new CURLFileSerializer class in a static way.
     *
     * @param CURLFile $curlfile
     */
    public static function create(CURLFile $curlfile)
    {
        return new static($curlfile);
    }

    /**
     * Serialize this class.
     *
     * @return string
     */
    public function serialize()
    {
        $fileInfo = array(
            'fileName' => $this->curlfile->getFileName(),
            'mimeType' => $this->curlfile->getMimeType(),
            'postFilename' => $this->curlfile->getPostFilename(),
        );

        return serialize($fileInfo);
    }

    /**
     * Unserializes the class.
     *
     * @param string $fileInfo
     */
    public function unserialize($fileInfo)
    {
        extract(unserialize($fileInfo)); // gives $fileName, $mimeType, $postFilename

        if ( (isset($fileName) && isset($mimeType) && isset($postFilename)) === false) {
            throw new UnexpectedValueException('Insufficient data provided to unserialize');
        }

        $this->curlfile = new CURLFile($fileName, $mimeType, $postFilename);
    }

    /**
     * Gives the CURLFile.
     *
     * @return CURLFile
     */
    public function getCURLFile()
    {
        return $this->curlfile;
    }
}
