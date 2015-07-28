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
     * Attempts to decode a mixed value into an integer
     * @param mixed $value
     * @return int
     * @throws InvalidTypeException
     */
    public function decodeValue($value)
    {
        if (is_int($value)) {
            return $value;
        }
        if (!is_numeric($value)) {
            if (is_object($value) || is_array($value)) {
                throw new InvalidTypeException("Cannot decode Array/Object into an Integer");
            }
            throw new InvalidTypeException("Value '$value' could not be decoded into an Integer");
        }
        $intVal = (int)($value + 0);
        if ($intVal != $value) {
            throw new InvalidTypeException("Value '$value' could not be decoded into an Integer");
        }
        return $intVal;
    }

}
