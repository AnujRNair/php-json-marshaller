<?php

namespace PhpJsonMarshaller\Type;

use PhpJsonMarshaller\Exception\InvalidTypeException;

/**
 * Class BoolType
 * @package PhpJsonMarshaller\Type
 */
class BoolType implements iType
{

    /**
     * Attempts to decode a mixed value into a boolean
     * @param mixed $value
     * @return bool
     * @throws InvalidTypeException
     */
    public function decodeValue($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_object($value) || is_array($value)) {
            throw new InvalidTypeException("Cannot decode Array/Object into a Boolean");
        }
        if ($value === 'true' || $value === 1) {
            return true;
        }
        if ($value === 'false' || $value === 0) {
            return false;
        }
        throw new InvalidTypeException("Value '$value' could not be decoded into a Boolean");
    }

}