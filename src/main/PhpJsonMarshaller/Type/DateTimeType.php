<?php

namespace PhpJsonMarshaller\Type;

use PhpJsonMarshaller\Exception\InvalidTypeException;

/**
 * Class DateTimeType
 * @package PhpJsonMarshaller\Type
 */
class DateTimeType implements iType
{

    /**
     * Attempts to decode a mixed value into a \DateTime
     * @param mixed $value
     * @return \DateTime
     * @throws InvalidTypeException
     */
    public function decodeValue($value)
    {
        if (!is_string($value)) {
            if (is_object($value) || is_array($value)) {
                throw new InvalidTypeException("Cannot decode Array/Object into a DateTime");
            }
            throw new InvalidTypeException("Value '$value' could not be decoded into a DateTime");
        }
        try {
            $retVal = new \DateTime($value);
            if ($retVal !== false) {
                return $retVal;
            }
        } catch (\Exception $e) {
        }
        throw new InvalidTypeException("Value '$value' could not be decoded into a DateTime");
    }

}
