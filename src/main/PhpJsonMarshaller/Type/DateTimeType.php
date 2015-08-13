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
 * Class DateTimeType
 * @package PhpJsonMarshaller\Type
 */
class DateTimeType implements iType
{

    protected $format = 'c';

    /**
     * Attempts to decode a mixed value into a \DateTime
     * @param mixed $value
     * @return \DateTime
     * @throws InvalidTypeException
     */
    public function decodeValue($value)
    {
        if (!is_string($value)) {
            throw new InvalidTypeException("Expected DateTime compatible string but received " . gettype($value));
        }
        try {
            $retVal = new \DateTime($value);
            if ($retVal !== false) {
                return $retVal;
            }
        } catch (\Exception $e) {
        }
        throw new InvalidTypeException("Expected DateTime compatible string but received " . gettype($value));
    }

    /**
     * Attempts to encode a DateTime
     * @param \DateTime $value
     * @return string
     * @throws InvalidTypeException
     */
    public function encodeValue($value)
    {
        if (!$value instanceof \DateTime) {
            throw new InvalidTypeException("Expected DateTime but received " . gettype($value));
        }
        return $value->format($this->format);
    }

}
