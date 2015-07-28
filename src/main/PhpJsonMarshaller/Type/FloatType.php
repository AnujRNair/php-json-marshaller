<?php

namespace PhpJsonMarshaller\Type;

use PhpJsonMarshaller\Exception\InvalidTypeException;

/**
 * Class FloatType
 * @package PhpJsonMarshaller\Type
 */
class FloatType implements iType
{

    /**
     * Attempts to decode a mixed value into a float
     * @param mixed $value
     * @return float
     * @throws InvalidTypeException
     */
    public function decodeValue($value)
    {
        if (is_float($value)) {
            return $value;
        }
        if (!is_numeric($value)) {
            if (is_object($value) || is_array($value)) {
                throw new InvalidTypeException("Cannot decode Array/Object into a Float");
            }
            throw new InvalidTypeException("Value '$value' could not be decoded into a Float");
        }
        return (float)($value + 0);
    }

}
