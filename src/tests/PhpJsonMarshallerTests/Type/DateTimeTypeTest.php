<?php

namespace PhpJsonMarshallerTests\Type;

use PhpJsonMarshaller\Type\DateTimeType;

class DateTimeTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var DateTimeType */
    protected $dateTimeType;

    public function setUp()
    {
        $this->dateTimeType = new DateTimeType();
    }

    /**
     * @return array
     */
    public function provideValidData()
    {
        return [
            ['2015-01-01', new \DateTime('2015-01-01')],
            ['2015-01-01 12:12:12', new \DateTime('2015-01-01 12:12:12')],
            ['2004-02-12T15:19:21+00:00', new \DateTime('2004-02-12T15:19:21+00:00')],
            ['Thu, 21 Dec 2000 16:01:07 +0200', new \DateTime('Thu, 21 Dec 2000 16:01:07 +0200')]
        ];
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return [
            [true],
            [1],
            [1.1],
            ['InvalidString'],
            ['1388605953000'],
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
        $result = $this->dateTimeType->decodeValue($input);
        $this->assertEquals($expected, $result, 'Valid input not decoded into a \DateTime');
    }

    /**
     * @dataProvider provideInvalidData
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidDecodes($input)
    {
        $this->dateTimeType->decodeValue($input);
    }

    public function testValidEncode()
    {
        $dateTime = new \DateTime('2015-01-01 12:12:12');
        $result = $this->dateTimeType->encodeValue($dateTime);
        $this->assertEquals($dateTime->format('c'), $result, 'Valid input not encoded into a \DateTime');
    }

    /**
     * @dataProvider provideInvalidData
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidEncodes($input)
    {
        $this->dateTimeType->encodeValue($input);
    }

}