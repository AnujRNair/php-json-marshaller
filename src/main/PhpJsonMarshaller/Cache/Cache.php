<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshaller\Cache;

use PhpJsonMarshaller\Cache\Storage\iStorage;
use PhpJsonMarshaller\Decoder\Object\ClassObject;
use PhpJsonMarshaller\Exception\CacheCollisionException;

/**
 * Class Cache
 * @package PhpJsonMarshaller\Cache
 */
class Cache
{

    /** @var iStorage */
    protected $storage;

    /**
     * @param iStorage $storage
     */
    public function __construct(
        iStorage $storage
    )
    {
        $this->storage = $storage;
    }

    /**
     * Get a ClassObject from the cache
     * @param string $className fully qualified namespace of the class to load
     * @return ClassObject a decoded class
     */
    public function getClass($className)
    {
        $cacheKey = $this->generateCacheKey(['className' => $className]);

        if (!$this->storage->has($cacheKey)) {
            return false;
        }

        return $this->storage->get($cacheKey);
    }

    /**
     * Set a ClassObject into the cache
     * @param string $className fully qualified namespace of the class to set
     * @param ClassObject $class the class to set
     * @throws CacheCollisionException
     */
    public function setClass($className, ClassObject $class)
    {
        $cacheKey = $this->generateCacheKey(['className' => $className]);

        if ($this->storage->has($cacheKey)) {
            throw new CacheCollisionException("Cannot set $className in the cache as it is already set");
        }

        $this->storage->set($cacheKey, $class);
    }

    /**
     * Generate a cache key from an input
     * @param array $input the array to generate a cache key from
     * @return string the cache key
     */
    protected function generateCacheKey(array $input)
    {
        return md5(serialize($input));
    }

}