<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    public function provideValidDecodeData()
    {
        return [
            ['', ''],
            ['This is a string', 'This is a string'],
            [true, '1'],
            ['1', '1'],
            [1, '1'],
            [null, ''],
            [['one' => 'two'], '{"one":"two"}'],
            [new classWithToStringMethod(), 'Converted to string!']
        ];
    }

    /**
     * @return array
     */
    public function provideInvalidDecodeData()
    {
        return [
            [new \StdClass()]
        ];
    }

    /**
     * @return array
     */
    public function provideValidEncodeData()
    {
        return [
            ['', ''],
            ['This is a string', 'This is a string'],
            [true, '1'],
            ['1', '1'],
            [1, '1'],
            [null, ''],
            [new classWithToStringMethod(), 'Converted to string!']
        ];
    }

    /**
     * @return array
     */
    public function provideInvalidEncodeData()
    {
        return [
            [new \StdClass()],
            [['one' => 'two']]
        ];
    }

    /**
     * @dataProvider provideValidDecodeData
     * @param $input
     * @param $expected
     */
    public function testValidDecodes($input, $expected)
    {
        $result = $this->stringType->decodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not decoded into a string');
    }

    /**
     * @dataProvider provideInvalidDecodeData
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidDecodes($input)
    {
        $this->stringType->decodeValue($input);
    }

    /**
     * @dataProvider provideValidEncodeData
     * @param $input
     * @param $expected
     */
    public function testValidEncodes($input, $expected)
    {
        $result = $this->stringType->encodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not encoded into a string');
    }

    /**
     * @dataProvider provideInvalidEncodeData
     * @param $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidEncodes($input)
    {
        $this->stringType->encodeValue($input);
    }

}


class classWithToStringMethod
{

    public function __toString()
    {
        return 'Converted to string!';
    }

}