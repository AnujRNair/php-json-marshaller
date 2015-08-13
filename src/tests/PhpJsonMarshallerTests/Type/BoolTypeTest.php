<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    public function provideValidDecodeData()
    {
        return [
            [true, true],
            [false, false],
            ['true', true],
            ['false', false],
            [1, true],
            [0, false]
        ];
    }

    /**
     * @return array
     */
    public function provideValidEncodeData()
    {
        return [
            [true, true],
            [false, false],
            [1, true],
            [0, false]
        ];
    }

    /**
     * @return array
     */
    public function provideInvalidData()
    {
        return [
            ['InvalidString'],
            [2],
            ['1'],
            [3.4],
            [new \DateTime('2015-01-01 12:12:12')],
            [[]],
            [null]
        ];
    }

    /**
     * @dataProvider provideValidDecodeData
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

    /**
     * @dataProvider provideValidEncodeData
     * @param $input
     * @param $expected
     */
    public function testValidEncodes($input, $expected)
    {
        $result = $this->boolType->encodeValue($input);
        $this->assertSame($expected, $result, 'Valid input not encoded into a boolean');
    }

    /**
     * @dataProvider provideInvalidData
     * @param mixed $input
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidEncodes($input)
    {
        $this->boolType->encodeValue($input);
    }

}