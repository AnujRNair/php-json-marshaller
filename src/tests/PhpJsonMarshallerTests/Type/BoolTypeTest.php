<?php

namespace PhpJsonMarshallerTests\Type;

use PhpJsonMarshaller\Type\BoolType;

class BoolTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var BoolType $boolType */
    protected $boolType;

    public function setUp()
    {
        $this->boolType = new BoolType();
    }

    /**
     * @return array
     */
    public function provideValidData()
    {
        return array(
            array(true, true),
            array(false, false),
            array('true', true),
            array('false', false),
            array(1, true),
            array(0, false)
        );
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return array(
            array('InvalidString'),
            array(2),
            array('1'),
            array(3.4),
            array(new \DateTime('2015-01-01 12:12:12')),
            array(array()),
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
        $result = $this->boolType->decodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not decoded into a boolean');
    }

    /**
     * @dataProvider provideInvalidData
     * @param mixed $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidDecodes($input)
    {
        $this->boolType->decodeValue($input);
    }

}