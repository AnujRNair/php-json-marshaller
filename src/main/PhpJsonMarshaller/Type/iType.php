<?php

namespace PhpJsonMarshaller\Type;

/**
 * Interface iType
 * @package PhpJsonMarshaller\Type
 */
interface iType
{

    /**
     * Attempts to decode a mixed value into a specific type
     * @param mixed $value
     * @return mixed
     */
    public function decodeValue($value);

    /**
     * Attempts to encode a value into a specific type
     * @param mixed $value
     * @return mixed
     */
    public function encodeValue($value);

}
