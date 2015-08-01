<?php

namespace PhpJsonMarshaller\Decoder;

use PhpJsonMarshaller\Annotations\MarshallConfig;
use PhpJsonMarshaller\Annotations\MarshallProperty;
use PhpJsonMarshaller\Cache\Cache;
use PhpJsonMarshaller\Decoder\Object\ClassObject;
use PhpJsonMarshaller\Decoder\Object\PropertyObject;
use PhpJsonMarshaller\Exception\ClassNotFoundException;
use PhpJsonMarshaller\Exception\DuplicateAnnotationException;
use PhpJsonMarshaller\Exception\MissingPropertyException;
use PhpJsonMarshaller\Reader\DoctrineAnnotationReader;

/**
 * A class to decode a class into a ClassObject container PropertyObjects
 * Class ClassDecoder
 * @package PhpJsonMarshaller\Decoder
 */
class ClassDecoder
{

    /**
     * An annotation reader instance to read annotations
     * @var DoctrineAnnotationReader $reader
     */
    protected $reader;

    /**
     * A class to cache decoded class objects
     * @var Cache $cache
     */
    protected $cache;


    /**
     * @param DoctrineAnnotationReader $reader A reader to read annotations
     * @param Cache $cache
     */
    public function __construct(
        DoctrineAnnotationReader $reader,
        Cache $cache = null
    )
    {
        $this->reader = $reader;
        $this->cache = $cache;
    }

    /**
     * Decodes a class into a ClassObject class
     * @param string $classString The class to decode. The full namespace must be passed in
     * @return ClassObject
     * @throws ClassNotFoundException
     */
    public function decodeClass($classString)
    {
        if (!class_exists($classString)) {
            throw new ClassNotFoundException("Class with name: '$classString' not found");
        }

        // Check the cache first and return if it exists
        if ($this->cache !== null) {
            if (false !== ($cachedClassObject = $this->cache->getClass($classString))) {
                return $cachedClassObject;
            }
        }

        /** @var PropertyObject[] $properties */
        $properties = [];
        $reflectedClass = new \ReflectionClass($classString);

        // Create class with config
        $classObject = $this->createClassObject($reflectedClass);

        // Decode public methods
        foreach ($reflectedClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $this->decodeMethod($method, $properties);
        }

        // Decode public properties
        /** @var \ReflectionProperty $property */
        foreach ($reflectedClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $this->decodeProperty($property, $properties);
        }
        $classObject->setProperties($properties);

        // Set in the cache
        if ($this->cache !== null) {
            $this->cache->setClass($classString, $classObject);
        }

        // Return Object
        return $classObject;
    }

    /**
     * Decodes a single method into a PropertyObject instance and adds to the properties array
     * @param \ReflectionMethod $method the reflected method to decode
     * @param PropertyObject[] $properties a reference to an array of decoded properties
     * @throws DuplicateAnnotationException
     * @throws MissingPropertyException
     */
    protected function decodeMethod(\ReflectionMethod $method, &$properties)
    {
        // Check if the public method has our annotation on it
        /** @var MarshallProperty $annotation */
        $annotation = $this->reader->getMethodAnnotation($method, '\PhpJsonMarshaller\Annotations\MarshallProperty');
        if (!$annotation) {
            return;
        }

        if (!$this->isAnnotationValid($annotation)) {
            throw new MissingPropertyException('MarshallProperty needs a name and type defined');
        }

        if (!isset($properties[$annotation->getName()])) {
            $classDecoderProperty = new PropertyObject(
                $annotation->getName(),
                $annotation->getType()
            );
        } else {
            $classDecoderProperty = $properties[$annotation->getName()];
        }

        $methodName = $method->getName();
        $subMethodName = substr($methodName, 0, 3);

        if ($subMethodName === 'set') {
            if ($classDecoderProperty->getSetter() !== null) {
                throw new DuplicateAnnotationException("A @MarshallProperty annotation to set {$annotation->getName()} already exists in the class");
            }
            $classDecoderProperty->setSetter($methodName);
        } elseif ($subMethodName === 'get'
            || (substr($annotation->getType(), 0, 4) === 'bool'
                && in_array(preg_replace('/' . $annotation->getName() . '$/i', '', $methodName), array('is', 'should', 'can', 'has'))
            )
        ) {
            if ($classDecoderProperty->getGetter() !== null) {
                throw new DuplicateAnnotationException("A @MarshallProperty annotation to get {$annotation->getName()} already exists in the class");
            }
            $classDecoderProperty->setGetter($methodName);
        }

        $properties[$annotation->getName()] = $classDecoderProperty;
    }

    /**
     * Decodes a single property into a PropertyObject instance and adds to the properties array
     * @param \ReflectionProperty $property a reflected property to decode
     * @param PropertyObject[] $properties a reference to an array of decoded properties
     * @throws DuplicateAnnotationException
     * @throws MissingPropertyException
     */
    protected function decodeProperty(\ReflectionProperty $property, &$properties)
    {
        // Check if the public property has our annotation on it
        /** @var MarshallProperty $annotation */
        $annotation = $this->reader->getPropertyAnnotation($property, '\PhpJsonMarshaller\Annotations\MarshallProperty');
        if (!$annotation) {
            return;
        }

        if (!$this->isAnnotationValid($annotation)) {
            throw new MissingPropertyException('MarshallProperty needs a name and type defined');
        }

        if (!isset($properties[$annotation->getName()])) {
            $classDecoderProperty = new PropertyObject(
                $annotation->getName(),
                $annotation->getType()
            );
        } else {
            $classDecoderProperty = $properties[$annotation->getName()];
        }

        if ($classDecoderProperty->getDirect() !== null) {
            throw new DuplicateAnnotationException("A @MarshallProperty annotation to directly get or set {$annotation->getName()} already exists in the class");
        }
        $classDecoderProperty->setDirect($property->getName());

        $properties[$annotation->getName()] = $classDecoderProperty;
    }

    /**
     * Creates a basic ClassObject instance, and sets the config properties on the class
     * @param \ReflectionClass $class The reflected class to create the ClassObject instance from
     * @return ClassObject
     */
    protected function createClassObject(\ReflectionClass $class)
    {
        $classObject = new ClassObject();

        /** @var MarshallConfig $config */
        $config = $this->reader->getClassAnnotation($class, '\PhpJsonMarshaller\Annotations\MarshallConfig');
        if (isset($config)) {
            if ($config->hasIgnoreUnknown()) {
                $classObject->setIgnoreUnknown($config->canIgnoreUnknown());
            }
        }

        return $classObject;
    }

    /**
     * Verifies that the MarshallProperty annotation has all necessary properties set
     * @param MarshallProperty $annotation
     * @return bool
     */
    protected function isAnnotationValid(MarshallProperty $annotation)
    {
        return $annotation->getName() !== null && $annotation->getType() !== null;
    }

}