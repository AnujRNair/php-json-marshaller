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
            throw new InvalidTypeException("Expected float but received " . gettype($value));
        }
        return (float)($value + 0);
    }

    /**
     * Attempt to encode a float
     * @param float $value
     * @return string
     * @throws InvalidTypeException
     */
    public function encodeValue($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidTypeException("Expected float but received " . gettype($value));
        }
        return (float)($value + 0);
    }

}
