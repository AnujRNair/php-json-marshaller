<?php

namespace PhpJsonMarshallerTests\Type;

use PhpJsonMarshaller\Type\IntType;

class IntTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var IntType */
    protected $intType;

    public function setUp()
    {
        $this->intType = new IntType();
    }

    /**
     * @return array
     */
    public function provideValidData()
    {
        return [
            [1, 1],
            [-10, -10],
            [0, 0],
            [1.0, 1]
        ];
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return [
            [true],
            [1.1],
            ['InvalidString'],
            [[]],
            [new \StdClass()],
            [null]
        ];
    }

    /**
     * @dataProvider provideValidData
     * @param $input
     * @param $expected
     */
    public function testValidDecodes($input, $expected)
    {
        $result = $this->intType->decodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not decoded into an integer');
    }

    /**
     * @dataProvider provideInvalidData
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidDecodes($input)
    {
        $this->intType->decodeValue($input);
    }

    /**
     * @dataProvider provideValidData
     * @param $input
     * @param $expected
     */
    public function testValidEncodes($input, $expected)
    {
        $result = $this->intType->encodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not encoded into an integer');
    }

    /**
     * @dataProvider provideInvalidData
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidEncodes($input)
    {
        $this->intType->encodeValue($input);
    }

}