<?php

namespace PhpJsonMarshallerTests\Reader;

use PhpJsonMarshaller\Reader\DoctrineAnnotationReader;

class DoctrineAnnotationReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testReaderCreated()
    {
        $reader = new DoctrineAnnotationReader();
        $this->assertInstanceOf(
            'PhpJsonMarshaller\Reader\DoctrineAnnotationReader',
            $reader,
            'Reader should be an instance of DoctrineAnnotationReader'
        );
    }

}