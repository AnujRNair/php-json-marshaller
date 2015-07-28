<?php

namespace PhpJsonMarshallerTests\Type;

use PhpJsonMarshaller\Type\FloatType;

class FloatTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var FloatType */
    protected $floatType;

    public function setUp()
    {
        $this->floatType = new FloatType();
    }

    /**
     * @return array
     */
    public function provideValidData()
    {
        return array(
            array(1.1, 1.1),
            array(1, 1.0),
            array('1.1', 1.1),
            array('1', 1.0),
            array(0x539, 1337.0),
            array(02471, 1337.0),
            array(0b10100111001, 1337.0),
            array(1337e0, 1337.0),
        );
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return array(
            array('InvalidString'),
            array(true),
            array(array()),
            array(new \DateTime()),
            array(null)
        );
    }

    /**
     * @param $input
     * @param $expected
     * @dataProvider provideValidData
     */
    public function testValidDecodes($input, $expected)
    {
        $result = $this->floatType->decodeValue($input);
        $this->assertSame($expected, $result);
    }

    /**
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     * @dataProvider provideInvalidData
     */
    public function testInvalidDecodes($input)
    {
        $this->floatType->decodeValue($input);
    }

}