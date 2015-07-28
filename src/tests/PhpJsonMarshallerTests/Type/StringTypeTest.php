<?php

namespace PhpJsonMarshallerTests\Type;

use PhpJsonMarshaller\Type\StringType;

class StringTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var StringType */
    protected $stringType;

    public function setUp()
    {
        $this->stringType = new StringType();
    }

    /**
     * @return array
     */
    public function provideValidData()
    {
        return array(
            array('', ''),
            array('This is a string', 'This is a string'),
            array(true, 'true'),
            array('1', '1'),
            array(1, '1'),
            array(null, ''),
            array(array('one' => 'two'), '{"one":"two"}'),
            array(new classWithToStringMethod(), 'Converted to string!')
        );
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return array(
            array(new \StdClass())
        );
    }

    /**
     * @dataProvider provideValidData
     * @param $input
     * @param $expected
     */
    public function testValidDecodes($input, $expected)
    {
        $result = $this->stringType->decodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not decoded into a String');
    }

    /**
     * @dataProvider provideInvalidData
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidDecodes($input)
    {
        $this->stringType->decodeValue($input);
    }

}


class classWithToStringMethod
{

    public function __toString()
    {
        return 'Converted to string!';
    }

}