<?php

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
        new PropertyTypeObject(PropertyTypeObject::TYPE_PRIMITIVE, $data);
    }

}
