<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshaller\Cache\Storage;

class InMemoryStorage implements iStorage
{

    /** @var array $cache */
    private $cache;

    /**
     * Returns boolean on whether the storage contains a value which has been set by $name
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return (isset($this->cache[$name]));
    }

    /**
     * Returns a value which has been set by $name
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return unserialize($this->cache[$name]);
        }
        return false;
    }

    /**
     * Sets a value into the storage with a key of $name
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        if ($value === null) {
            throw new \InvalidArgumentException('Cannot set null into InMemory storage');
        }
        $this->cache[$name] = serialize($value);
    }

}