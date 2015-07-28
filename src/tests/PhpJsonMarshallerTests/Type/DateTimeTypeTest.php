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
        return array(
            array('2015-01-01', new \DateTime('2015-01-01')),
            array('2015-01-01 12:12:12', new \DateTime('2015-01-01 12:12:12')),
            array('2004-02-12T15:19:21+00:00', new \DateTime('2004-02-12T15:19:21+00:00')),
            array('Thu, 21 Dec 2000 16:01:07 +0200', new \DateTime('Thu, 21 Dec 2000 16:01:07 +0200'))
        );
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return array(
            array(true),
            array(1),
            array(1.1),
            array('InvalidString'),
            array('1388605953000'),
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

}