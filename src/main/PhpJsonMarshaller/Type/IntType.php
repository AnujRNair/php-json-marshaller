<?php

namespace PhpJsonMarshaller\Type;

use PhpJsonMarshaller\Exception\InvalidTypeException;

/**
 * Class IntType
 * @package PhpJsonMarshaller\Type
 */
class IntType implements iType
{

    /**
     * Validates the value is a valid integer
     * @param $value
     * @return int
     * @throws InvalidTypeException
     */
    protected function validateAndCast($value)
    {
        if (is_int($value)) {
            return $value;
        }
        if (!is_numeric($value)) {
            throw new InvalidTypeException("Expected integer but received " . gettype($value));
        }
        $intVal = (int)($value + 0);
        if ($intVal != $value) {
            throw new InvalidTypeException("Value '$value' could not be encoded/decoded into an integer ");
        }
        return $intVal;
    }

    /**
     * Attempts to decode a mixed value into an integer
     * @param mixed $value
     * @return int
     */
    public function decodeValue($value)
    {
        return $this->validateAndCast($value);
    }

    /**
     * Attempt to encode an Integer
     * @param int $value
     * @return string
     */
    public function encodeValue($value)
    {
        return $this->validateAndCast($value);
    }

}
