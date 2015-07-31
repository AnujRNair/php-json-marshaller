<?php

namespace PhpJsonMarshallerTests\Marshaller;

use PhpJsonMarshaller\Decoder\ClassDecoder;
use PhpJsonMarshaller\Marshaller\JsonMarshaller;
use PhpJsonMarshaller\Reader\DoctrineAnnotationReader;
use PhpJsonMarshallerTests\ExampleClass\Address;
use PhpJsonMarshallerTests\ExampleClass\Flag;
use PhpJsonMarshallerTests\ExampleClass\PropertyNone;
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

    public function invalidClassDataProvider()
    {
        return [
            ['InvalidString'],
            [1],
            [1.1],
            [true]
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
    public function testUnmarshallFailOnUnknownIfIgnoreUnknownFalse()
    {
        $this->marshaller->unmarshall($this->complexKeyValueArrayObject, 'PhpJsonMarshallerTests\ExampleClass\ClassComplete');
    }

    /**
     * @expectedException \PhpJsonMarshaller\Exception\InvalidTypeException
     */
    public function testUnmarshallInvalidType()
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

    /**
     * @dataProvider invalidClassDataProvider
     * @expectedException \PhpJsonMarshaller\Exception\JsonDecodeException
     * @param $data
     */
    public function testMarshallNonExistantClass($data)
    {
        $this->marshaller->marshall($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMarshallClassWithNoProperties()
    {
        $noPropertiesClass = new PropertyNone();
        $this->marshaller->marshall($noPropertiesClass);
    }

    public function testMarshallViaGetters()
    {
        $address = new Address();
        $address->id = 1;
        $address->state = 'California';
        $address->street = '123 Main Street';
        $address->zip = 94060;

        $flag1 = new Flag();
        $flag1->id = 11087;
        $flag1->name = "Fraud";
        $flag1->value = 0;

        $flag2 = new Flag();
        $flag2->id = 11088;
        $flag2->name = "FirstLogin";
        $flag2->value = true;

        $user = new User();
        $user->setId(12345);
        $user->setFirstName('Anuj');
        $user->setActive(true);
        $user->setFirstLogin(new \DateTime('2015-08-12 11:45:32'));
        $user->setRank(5.5);
        $user->setAddress($address);
        $user->setFlags([$flag1, $flag2]);
        $user->setLoginDates([
            new \DateTime('2015-08-12 11:40:00'),
            new \DateTime('2015-08-12 11:42:00'),
            new \DateTime('2015-08-12 11:44:00')
        ]);

        $json = $this->marshaller->marshall($user);
        $decoded = json_decode($json, true);

        $this->assertEquals($user->getId(), $decoded['id']);
        $this->assertEquals($user->getFirstName(), $decoded['firstName']);
        $this->assertEquals($user->isActive(), $decoded['active']);
        $this->assertEquals($user->getRank(), $decoded['rank']);
        $this->assertEquals($user->getLoginDates()[0]->format('c'), $decoded['loginDates'][0]);
        $this->assertEquals($user->getLoginDates()[1]->format('c'), $decoded['loginDates'][1]);
        $this->assertEquals($user->getLoginDates()[2]->format('c'), $decoded['loginDates'][2]);
    }

    public function testMarshallViaDirect()
    {
        $address = new Address();
        $address->id = 1;
        $address->state = 'California';
        $address->street = '123 Main Street';
        $address->zip = 94060;

        $flag1 = new Flag();
        $flag1->id = 11087;
        $flag1->name = "Fraud";
        $flag1->value = 0;

        $flag2 = new Flag();
        $flag2->id = 11088;
        $flag2->name = "FirstLogin";
        $flag2->value = true;

        $user = new UserAlternate();
        $user->id = 12345;
        $user->address = $address;
        $user->flags = [$flag1, $flag2];

        $json = $this->marshaller->marshall($user);
        $decoded = json_decode($json, true);

        $this->assertEquals($user->id, $decoded['id']);
        $this->assertEquals($user->address->id, $decoded['address']['id']);
        $this->assertEquals($user->address->state, $decoded['address']['state']);
        $this->assertEquals($user->address->street, $decoded['address']['street']);
        $this->assertEquals($user->address->zip, $decoded['address']['zipcode']);
        $this->assertEquals($user->flags[0]->id, $decoded['flags'][0]['id']);
        $this->assertEquals($user->flags[0]->name, $decoded['flags'][0]['name']);
        $this->assertEquals($user->flags[0]->value, $decoded['flags'][0]['value']);
        $this->assertEquals($user->flags[1]->id, $decoded['flags'][1]['id']);
        $this->assertEquals($user->flags[1]->name, $decoded['flags'][1]['name']);
        $this->assertEquals($user->flags[1]->value, $decoded['flags'][1]['value']);
    }

}