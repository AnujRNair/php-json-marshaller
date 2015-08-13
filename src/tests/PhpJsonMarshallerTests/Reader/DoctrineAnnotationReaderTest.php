<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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