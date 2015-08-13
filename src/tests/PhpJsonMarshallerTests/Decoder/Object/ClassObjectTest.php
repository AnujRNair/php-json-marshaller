<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\Decoder\Object;

use PhpJsonMarshaller\Decoder\Object\ClassObject;
use PhpJsonMarshaller\Decoder\Object\PropertyObject;

class ClassObjectTest extends \PHPUnit_Framework_TestCase
{

    public function testGetAndSetMultipleProperties()
    {
        $propertyObjects = [
            'id' => new PropertyObject(
                'id',
                'int'
            )
        ];

        $classObject = new ClassObject();
        $classObject->setProperties($propertyObjects);

        $this->assertEquals($propertyObjects, $classObject->getProperties());
    }

    public function testGetAndHasSingleProperty()
    {
        $propertyObject = new PropertyObject(
            'id',
            'int'
        );
        $propertyObjects = [
            'id' => $propertyObject
        ];

        $classObject = new ClassObject();
        $classObject->setProperties($propertyObjects);

        $this->assertEquals(true, $classObject->hasProperty('id'));
        $this->assertEquals($propertyObject, $classObject->getProperty('id'));
    }

    public function testIgnoreUnknown()
    {
        $classObject = new ClassObject();
        $classObject->setIgnoreUnknown(true);
        $this->assertEquals(true, $classObject->canIgnoreUnknown());
    }

}
