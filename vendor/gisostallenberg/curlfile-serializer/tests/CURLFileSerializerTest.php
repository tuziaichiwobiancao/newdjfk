<?php

namespace GisoStallenberg\CURLFileSerializer\tests;

use CURLFile;
use GisoStallenberg\CURLFileSerializer\CURLFileSerializer;
use PHPUnit\Framework\TestCase;

class CURLFileSerializerTest extends TestCase
{
    /**
     * Test if serialize works.
     */
    public function testSerializeCURLFile()
    {
        $curlFileSerializer = CURLFileSerializer::create(new CURLFile(__DIR__.'/Resources/file.txt'));
        $serialized = serialize($curlFileSerializer);

        $this->assertTrue(is_string($serialized));
    }

    /**
     * Test if unserialize works.
     */
    public function testUnserializeCURLFile()
    {
        $curlFileSerializer = CURLFileSerializer::create(new CURLFile(__DIR__.'/Resources/file.txt'));
        $serialized = serialize($curlFileSerializer);
        $curlFileSerializer = unserialize($serialized);

        $this->assertInstanceOf(
            'GisoStallenberg\\CURLFileSerializer\\CURLFileSerializer',
            $curlFileSerializer
        );
    }

    /**
     * Test if not serializing at all gives a CURLFile.
     */
    public function testNotSerializingGivesACURLFile()
    {
        $curlFileSerializer = CURLFileSerializer::create(new CURLFile(__DIR__.'/Resources/file.txt'));

        $this->assertInstanceOf(
            'CURLFile',
            $curlFileSerializer->getCURLFile()
        );
    }

    /**
     * Test if CURLFile can be restored.
     */
    public function testCURLFileIsRestored()
    {
        $curlFileSerializer = CURLFileSerializer::create(new CURLFile(__DIR__.'/Resources/file.txt'));
        $serialized = serialize($curlFileSerializer);
        $curlFileSerializer = unserialize($serialized);

        $this->assertInstanceOf(
            'CURLFile',
            $curlFileSerializer->getCURLFile()
        );
    }

    /**
     * Test if file contents is the same after serializing and unserializing.
     */
    public function testFileIsSameFileAfterSerializingAndUnserializing()
    {
        $file = __DIR__.'/Resources/file.txt';
        $expectedContent = file_get_contents($file);

        $curlFileSerializer = CURLFileSerializer::create(new CURLFile($file));
        $serialized = serialize($curlFileSerializer);
        $curlFileSerializer = unserialize($serialized);

        $actualContent = file_get_contents($curlFileSerializer->getCURLFile()->getFilename());

        $this->assertSame($expectedContent, $actualContent);
    }

    /**
     * When not all data is provided while unserializing, it should fail
     */
    public function testCallingUnserializeDirectlyWithWrongDataFails()
    {
        $this->expectException('\UnexpectedValueException');

        $fakeInfo = serialize(array('fake' => 'info'));

        CURLFileSerializer::create(new CURLFile(__DIR__.'/Resources/file.txt'))
            ->unserialize($fakeInfo);
    }
}
