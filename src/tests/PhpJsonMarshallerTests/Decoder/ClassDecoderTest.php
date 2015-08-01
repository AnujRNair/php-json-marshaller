<?php

namespace PhpJsonMarshallerTests\Decoder;

use PhpJsonMarshaller\Decoder\ClassDecoder;
use PhpJsonMarshaller\Reader\DoctrineAnnotationReader;

class ClassDecoderTest extends \PHPUnit_Framework_TestCase
{

    /** @var ClassDecoder */
    protected $decoder;

    public function setUp()
    {
        $this->decoder = new ClassDecoder(new DoctrineAnnotationReader());
    }

    /**
     * @return array
     */
    public function duplicateAnnotationExceptionProvider()
    {
        return array(
            array('\PhpJsonMarshallerTests\ExampleClass\PropertyDirectDuplicate'),
            array('\PhpJsonMarshallerTests\ExampleClass\PropertyGetterDuplicate'),
            array('\PhpJsonMarshallerTests\ExampleClass\PropertySetterDuplicate')
        );
    }

    /**
     * @return array
     */
    public function missingPropertyExceptionProvider()
    {
        return array(
            array('\PhpJsonMarshallerTests\ExampleClass\PropertyMissing'),
            array('\PhpJsonMarshallerTests\ExampleClass\MethodMissing')
        );
    }

    /**
     * @dataProvider duplicateAnnotationExceptionProvider
     * @expectedException \PhpJsonMarshaller\Exception\DuplicateAnnotationException
     * @param string $classString
     */
    public function testClassWithDuplicateProperty($classString)
    {
        $this->decoder->decodeClass($classString);
    }

    /**
     * @dataProvider missingPropertyExceptionProvider
     * @expectedException \PhpJsonMarshaller\Exception\MissingPropertyException
     * @param string $classString
     */
    public function testClassWithMissingProperty($classString)
    {
        $this->decoder->decodeClass($classString);
    }

    /**
     * @expectedException \PhpJsonMarshaller\Exception\ClassNotFoundException
     */
    public function testClassNotFoundForNonExistentClass()
    {
        $this->decoder->decodeClass('\PhpJsonMarshallerTests\ExampleClass\NonExistent');
    }

    /**
     * @throws \PhpJsonMarshaller\Exception\ClassNotFoundException
     */
    public function testClassWithNoProperty()
    {
        $result = $this->decoder->decodeClass('\PhpJsonMarshallerTests\ExampleClass\PropertyNone');
        $this->assertEquals(0, count($result->getProperties()), 'Class should have no marshall properties');
    }

    /**
     * @throws \PhpJsonMarshaller\Exception\ClassNotFoundException
     */
    public function testClassWithNoMethod()
    {
        $result = $this->decoder->decodeClass('\PhpJsonMarshallerTests\ExampleClass\MethodNone');
        $this->assertEquals(0, count($result->getProperties()), 'Class should have no marshall methods');
    }

    /**
     * @throws \PhpJsonMarshaller\Exception\ClassNotFoundException
     */
    public function testClassSuccessfulDecode()
    {
        $result = $this->decoder->decodeClass('\PhpJsonMarshallerTests\ExampleClass\ClassCannotIgnoreUnknown');

        $this->assertEquals(3, count($result->getProperties()));
        $this->assertEquals(false, $result->canIgnoreUnknown());

        $this->assertEquals(true, $result->hasProperty('id'));
        $this->assertEquals(true, $result->getProperty('id')->hasAnnotationName());
        $this->assertEquals('id', $result->getProperty('id')->getAnnotationName());
        $this->assertEquals(true, $result->getProperty('id')->hasAnnotationType());
        $this->assertEquals('int', $result->getProperty('id')->getAnnotationType());
        $this->assertEquals('id', $result->getProperty('id')->getDirect());
        $this->assertEquals(true, $result->getProperty('id')->hasDirect());
        $this->assertEquals(false, $result->getProperty('id')->hasGetter());
        $this->assertEquals(false, $result->getProperty('id')->hasSetter());

        $this->assertEquals(true, $result->hasProperty('active'));
        $this->assertEquals(true, $result->getProperty('active')->hasAnnotationName());
        $this->assertEquals('active', $result->getProperty('active')->getAnnotationName());
        $this->assertEquals(true, $result->getProperty('active')->hasAnnotationType());
        $this->assertEquals('boolean', $result->getProperty('active')->getAnnotationType());
        $this->assertEquals(false, $result->getProperty('active')->hasDirect());
        $this->assertEquals(true, $result->getProperty('active')->hasGetter());
        $this->assertEquals(true, $result->getProperty('active')->hasSetter());
        $this->assertEquals('setActive', $result->getProperty('active')->getSetter());
        $this->assertEquals('isActive', $result->getProperty('active')->getGetter());

        $this->assertEquals(true, $result->hasProperty('name'));
        $this->assertEquals(true, $result->getProperty('name')->hasAnnotationName());
        $this->assertEquals('name', $result->getProperty('name')->getAnnotationName());
        $this->assertEquals(true, $result->getProperty('name')->hasAnnotationType());
        $this->assertEquals('string', $result->getProperty('name')->getAnnotationType());
        $this->assertEquals(false, $result->getProperty('name')->hasDirect());
        $this->assertEquals(true, $result->getProperty('name')->hasGetter());
        $this->assertEquals(true, $result->getProperty('name')->hasSetter());
        $this->assertEquals('getName', $result->getProperty('name')->getGetter());
        $this->assertEquals('setName', $result->getProperty('name')->getSetter());
    }


}
