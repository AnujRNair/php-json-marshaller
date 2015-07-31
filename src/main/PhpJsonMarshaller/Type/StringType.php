<?php

namespace PhpJsonMarshaller\Type;

use PhpJsonMarshaller\Exception\InvalidTypeException;

/**
 * Class StringType
 * @package PhpJsonMarshaller\Type
 */
class StringType implements iType
{

    /**
     * Attempts to decode a mixed value into a string
     * @param mixed $value
     * @return string
     * @throws InvalidTypeException
     */
    public function decodeValue($value)
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_object($value) && !method_exists($value, '__toString')) {
            throw new InvalidTypeException('Expected string but received object with no __toString method');
        }
        if (is_array($value)) {
            return json_encode($value);
        }
        return (string)('' . $value);
    }

    public function encodeValue($value)
    {
        try {
            $result = (string)('' . $value);
        } catch (\Exception $e) {
            throw new InvalidTypeException("Could not encode " . gettype($value) . " to a string");
        }
        return $result;
    }

}
