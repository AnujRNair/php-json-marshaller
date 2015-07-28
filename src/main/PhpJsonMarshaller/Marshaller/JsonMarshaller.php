<?php

namespace PhpJsonMarshaller\Marshaller;

use PhpJsonMarshaller\Decoder\ClassDecoder;
use PhpJsonMarshaller\Exception\InvalidTypeException;
use PhpJsonMarshaller\Exception\JsonDecodeException;
use PhpJsonMarshaller\Exception\UnknownPropertyException;
use PhpJsonMarshaller\Type\BoolType;
use PhpJsonMarshaller\Type\DateTimeType;
use PhpJsonMarshaller\Type\FloatType;
use PhpJsonMarshaller\Type\IntType;
use PhpJsonMarshaller\Type\iType;
use PhpJsonMarshaller\Type\StringType;

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
        // TODO: How about constructor arguments?
        $newClass = new $classString;

        foreach ($assocArray as $key => $value) {

            // TODO: Magic Setter
            if ($decodedClass->hasProperty($key)) {
                $result = null;
                $property = $decodedClass->getProperty($key);
                $type = $this->getType($property->getJsonType());

                if ($type instanceof iType) {
                    $result = $type->decodeValue($value);
                } elseif ($type === 'object') {
                    $result = $this->unmarshallClass($value, $property->getJsonType());
                } elseif ($type === 'array') {
                    $rawArrayType = substr($property->getJsonType(), 0, strpos($property->getJsonType(), "["));
                    $iArrayType = $this->getType($rawArrayType);
                    foreach ($value as $val) {
                        if ($iArrayType instanceof iType) {
                            $result[] = $iArrayType->decodeValue($val);
                        } else {
                            $result[] = $this->unmarshallClass($val, $rawArrayType);
                        }
                    }
                }

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

    /**
     * Returns a typed object from a string type
     * @param string $type the type
     * @return BoolType|DateTimeType|FloatType|IntType|StringType|string
     * @throws InvalidTypeException
     */
    protected function getType($type)
    {
        // Remove leading slash, if any
        $type = ltrim($type, '\\');
        // Check for array
        $pos = strrpos($type, '[');

        if ($pos === false) {
            switch (strtolower($type)) {
                case 'integer':
                case 'int':
                    return new IntType();
                case 'boolean':
                case 'bool':
                    return new BoolType();
                case 'string':
                    return new StringType();
                case 'float':
                    return new FloatType();
                case 'datetime':
                    return new DateTimeType();
                default:
                    // Guessing it's an object
                    return 'object';
            }
        }

        if ($type[$pos + 1] !== ']') {
            throw new InvalidTypeException('Cannot nest a type inside of an array');
        }

        // guessing it's an array
        return 'array';
    }

}
