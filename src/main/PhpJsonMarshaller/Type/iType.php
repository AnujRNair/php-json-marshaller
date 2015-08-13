<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
