<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            throw new InvalidTypeException("Expected boolean but received " . gettype($value));
        }
        if ($value === 'true' || $value === 1) {
            return true;
        }
        if ($value === 'false' || $value === 0) {
            return false;
        }
        throw new InvalidTypeException("Expected boolean but received " . gettype($value));
    }

    /**
     * Attempts to encode a boolean
     * @param boolean $value
     * @return string
     * @throws InvalidTypeException
     */
    public function encodeValue($value)
    {
        if (!(is_bool($value) || $value === 0 || $value === 1)) {
            throw new InvalidTypeException("Expected boolean but received " . gettype($value));
        }
        return !!$value;
    }

}