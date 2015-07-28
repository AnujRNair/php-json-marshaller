<?php

namespace PhpJsonMarshallerTests\Marshaller;

use PhpJsonMarshaller\Decoder\ClassDecoder;
use PhpJsonMarshaller\Marshaller\JsonMarshaller;
use PhpJsonMarshaller\Reader\DoctrineAnnotationReader;
use PhpJsonMarshallerTests\ExampleClass\User;
use PhpJsonMarshallerTests\ExampleClass\UserAlternate;

class JsonMarshallerTest extends \PHPUnit_Framework_TestCase
{

    /** @var JsonMarshaller */
    protected $marshaller;

    /** @var string */
    protected $basicKeyValue;

    /** @var string */
    protected $complexKeyValueArrayObject;

    public function setUp()
    {
        $this->marshaller = new JsonMarshaller(new ClassDecoder(new DoctrineAnnotationReader()));
        $this->basicKeyValue = file_get_contents(__DIR__ . '/../ExampleJson/BasicKeyValue.json');
        $this->complexKeyValueArrayObject = file_get_contents(__DIR__ . '/../ExampleJson/ComplexKeyValueArrayObject.json');
    }

    public function emptyStringDataProvider()
    {
        return [
            [''],
            [null],
            ['null']
        ];
    }

    /**
     * @dataProvider emptyStringDataProvider
     * @param $input
     */
    public function testUnmarshallEmptyString($input)
    {
        $result = $this->marshaller->unmarshall($input, 'PhpJsonMarshallerTests\ExampleClass\User');
        $this->assertSame(null, $result, 'Unmarshalling an empty string should result in null');
    }

    /**
     * @expectedException \PhpJsonMarshaller\Exception\JsonDecodeException
     */
    public function testUnmarshallNonJsonString()
    {
        $this->marshaller->unmarshall('InvalidString', 'PhpJsonMarshallerTests\ExampleClass\User');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnmarshallEmptyJsonString()
    {
        $this->marshaller->unmarshall('{}', 'PhpJsonMarshallerTests\ExampleClass\User');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnmarshallWithNoPropertiesDefined()
    {
        $this->marshaller->unmarshall($this->basicKeyValue, 'PhpJsonMarshallerTests\ExampleClass\MethodNone');
    }

    /**
     * @expectedException \PhpJsonMarshaller\Exception\UnknownPropertyException
     */
    public function testFailOnUnknownIfIgnoreUnknownFalse()
    {
        $this->marshaller->unmarshall($this->complexKeyValueArrayObject, 'PhpJsonMarshallerTests\ExampleClass\ClassComplete');
    }

    /**
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testInvalidType()
    {
        $this->marshaller->unmarshall($this->complexKeyValueArrayObject, 'PhpJsonMarshallerTests\ExampleClass\PropertyInvalidType');
    }

    public function testUnmarshallViaSetters()
    {
        $json = json_decode($this->complexKeyValueArrayObject, true);

        /** @var User $user */
        $user = $this->marshaller->unmarshall($this->complexKeyValueArrayObject, 'PhpJsonMarshallerTests\ExampleClass\User');

        $this->assertSame($json['id'], $user->getId());
        $this->assertSame($json['firstName'], $user->getFirstName());
        $this->assertSame($json['active'], $user->isActive());
        $this->assertEquals(new \DateTime($json['firstLogin']), $user->getFirstLogin());
        $this->assertSame($json['address']['id'], $user->getAddress()->id);
        $this->assertSame($json['flags'][0]['id'], $user->getFlags()[0]->id);
        $this->assertEquals(new \DateTime($json['loginDates'][0]), $user->getLoginDates()[0]);
    }

    public function testUnmarshallViaDirect()
    {
        $json = json_decode($this->complexKeyValueArrayObject, true);

        /** @var UserAlternate $user */
        $user = $this->marshaller->unmarshall($this->complexKeyValueArrayObject, 'PhpJsonMarshallerTests\ExampleClass\UserAlternate');

        $this->assertSame($json['id'], $user->id);
        $this->assertSame($json['address']['id'], $user->address->id);
        $this->assertSame($json['flags'][0]['id'], $user->flags[0]->id);
    }

}
