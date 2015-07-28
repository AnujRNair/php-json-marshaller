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
            throw new InvalidTypeException('Cannot convert an Object to a String without a toString method');
        }
        if (is_array($value)) {
            return json_encode($value);
        }
        if (is_bool($value)) {
            return ($value ? 'true' : 'false');
        }
        return (string)('' . $value);
    }

}
