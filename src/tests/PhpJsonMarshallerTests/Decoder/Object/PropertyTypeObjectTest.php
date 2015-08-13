<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\Decoder\Object;

use PhpJsonMarshaller\Decoder\Object\PropertyTypeObject;

class PropertyTypeObjectTest extends \PHPUnit_Framework_TestCase
{

    public function provideInvalidData()
    {
        return [
            [[]],
            [new \StdClass()],
            [10]
        ];
    }

    /**
     * @dataProvider provideInvalidData
     * @expectedException \InvalidArgumentException
     * @param $data
     */
    public function testInvalidTypeParameter($data)
    {
        new PropertyTypeObject($data, null);
    }

    /**
     * @dataProvider provideInvalidData
     * @expectedException \InvalidArgumentException
     * @param $data
     */
    public function testInvalidNameParameter($data)
    {
        new PropertyTypeObject(PropertyTypeObject::TYPE_SCALAR, $data);
    }

}
