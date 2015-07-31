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
        return [
            [1.1, 1.1],
            [1, 1.0],
            ['1.1', 1.1],
            ['1', 1.0],
            [0x539, 1337.0],
            [02471, 1337.0],
            [0b10100111001, 1337.0],
            [1337e0, 1337.0],
        ];
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return [
            ['InvalidString'],
            [true],
            [[]],
            [new \DateTime()],
            [null]
        ];
    }

    /**
     * @param $input
     * @param $expected
     * @dataProvider provideValidData
     */
    public function testValidDecodes($input, $expected)
    {
        $result = $this->floatType->decodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not decoded into a float');
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

    /**
     * @param $input
     * @param $expected
     * @dataProvider provideValidData
     */
    public function testValidEncodes($input, $expected)
    {
        $result = $this->floatType->encodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not encoded into a float');
    }

    /**
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     * @dataProvider provideInvalidData
     */
    public function testInvalidEncodes($input)
    {
        $this->floatType->encodeValue($input);
    }

}