<?php

namespace PhpJsonMarshaller\Cache\Storage;

/**
 * Interface iStorage
 * @package PhpJsonMarshaller\Cache\Storage
 */
interface iStorage
{

    /**
     * Returns boolean on whether the storage contains a value which has been set by $name
     * @param string $name
     * @return boolean
     */
    public function has($name);

    /**
     * Returns a value which has been set by $name
     * @param string $name
     * @return mixed
     */
    public function get($name);

    /**
     * Sets a value into the storage with a key of $name
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value);

}
