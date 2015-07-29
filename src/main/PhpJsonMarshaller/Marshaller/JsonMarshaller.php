<?php

namespace PhpJsonMarshaller\Marshaller;

use PhpJsonMarshaller\Decoder\ClassDecoder;
use PhpJsonMarshaller\Decoder\Object\PropertyTypeObject;
use PhpJsonMarshaller\Exception\InvalidTypeException;
use PhpJsonMarshaller\Exception\JsonDecodeException;
use PhpJsonMarshaller\Exception\UnknownPropertyException;

/**
 * Marshall and Unmarshall a JSON string to and from a particular class
 * Class JsonMarshaller
 * @package PhpJsonMarshaller\Marshaller
 */
class JsonMarshaller
{

    /**
     * An instance of the class decoder used to decode a class into a ClassObject
     * container PropertyObjects
     * @var ClassDecoder
     */
    protected $classDecoder;

    /**
     * @param ClassDecoder $classDecoder
     */
    public function __construct(
        ClassDecoder $classDecoder
    )
    {
        $this->classDecoder = $classDecoder;
    }

    /**
     * UnMarshall a json string into a PHP class
     * @param string $string the json string
     * @param string $classString a fully qualified namespaced class for the json to be inserted into
     * @return mixed A fully populated <$classString> class, containing values from the json string
     * @throws JsonDecodeException
     * @throws UnknownPropertyException
     */
    public function unmarshall($string, $classString)
    {
        if ($string === null || $string === 'null' || $string === '') {
            return null;
        }

        // Decode the string into an assoc array and check it's valid
        $assocArray = json_decode($string, true);

        if (json_last_error() !== 0) {
            throw new JsonDecodeException('Could not decode the JSON string');
        }
        if (empty($assocArray)) {
            throw new \InvalidArgumentException('You cannot unmarshall an empty string');
        }

        return $this->unmarshallClass($assocArray, $classString);
    }

    /**
     * Sets the values of an associative array into a <$classString> class
     * @param array $assocArray the associative array containing all of our data
     * @param string $classString the fully qualified namespaced class which will receive the data
     * @return mixed A fully populated <$classString> class, containing values from the assoc array
     * @throws InvalidTypeException
     * @throws UnknownPropertyException
     * @throws \PhpJsonMarshaller\Exception\ClassNotFoundException
     */
    protected function unmarshallClass($assocArray, $classString)
    {
        // Decode the class and it's properties
        $decodedClass = $this->classDecoder->decodeClass($classString);
        if (count($decodedClass->getProperties()) == 0) {
            throw new \InvalidArgumentException("Class $classString doesn't have any @MarshallProperty annotations defined");
        }

        // Create a new class
        $newClass = new $classString;

        foreach ($assocArray as $key => $value) {

            if ($decodedClass->hasProperty($key)) {
                $result = null;
                $property = $decodedClass->getProperty($key);
                $propertyType = $property->getPropertyType();

                // Decode the value into our result
                if ($propertyType->getType() === PropertyTypeObject::TYPE_PRIMITIVE) {
                    $result = $propertyType->getValue()->decodeValue($value);
                } elseif ($propertyType->getType() === PropertyTypeObject::TYPE_OBJECT) {
                    $result = $this->unmarshallClass($value, $propertyType->getValue());
                } elseif ($propertyType->getType() === PropertyTypeObject::TYPE_ARRAY) {
                    $subPropertyType = $propertyType->getValue();
                    foreach ($value as $val) {
                        if ($subPropertyType->getType() === PropertyTypeObject::TYPE_PRIMITIVE) {
                            $result[] = $subPropertyType->getValue()->decodeValue($val);
                        } else {
                            $result[] = $this->unmarshallClass($val, $subPropertyType->getValue());
                        }
                    }
                }

                // Set our result into the class
                if ($property->hasDirect()) {
                    $newClass->{$property->getDirect()} = $result;
                } elseif ($property->hasSetter()) {
                    $newClass->{$property->getSetter()}($result);
                }
            } else {
                if ($decodedClass->canIgnoreUnknown() === false) {
                    throw new UnknownPropertyException(
                        "Unknown property '$key' in class '$classString' and cannot ignore unknown properties.
                        (You can add a MarshallConfig annotation on the class to change this)"
                    );
                }
            }
        }

        return $newClass;
    }

}