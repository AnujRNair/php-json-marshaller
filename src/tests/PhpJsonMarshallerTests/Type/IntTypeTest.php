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
        return array(
            array(1, 1),
            array(-10, -10),
            array(0, 0),
            array(1.0, 1)
        );
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return array(
            array(true),
            array(1.1),
            array('InvalidString'),
            array(array()),
            array(new \StdClass()),
            array(null)
        );
    }

    /**
     * @dataProvider provideValidData
     * @param $input
     * @param $expected
     */
    public function testValidDecodes($input, $expected)
    {
        $result = $this->intType->decodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not decoded into an Integer');
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

}