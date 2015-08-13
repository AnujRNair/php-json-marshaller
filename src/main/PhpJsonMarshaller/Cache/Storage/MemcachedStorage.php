<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshaller\Cache\Storage;

use Memcached;

/**
 * Class MemcachedStorage
 * @package PhpJsonMarshaller\Cache\Storage
 */
class MemcachedStorage implements iStorage
{

    /**
     * @var Memcached $memcached
     */
    protected $memcached;

    /**
     * @var string $keyPrefix
     */
    protected $keyPrefix = null;

    /**
     * @var int $ttl
     */
    protected $ttl = null;

    /**
     * @param array $servers
     * @param int $ttl
     * @param string $keyPrefix
     * @param int $connectionTimeout
     */
    public function __construct($servers = [], $ttl = null, $keyPrefix = null, $connectionTimeout = null)
    {
        if (!class_exists('memcached')) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException("Memcached is not available. Cannot instantiate a memcached driven storage module.");
            // @codeCoverageIgnoreEnd
        }

        $this->ttl = $ttl;

        if (empty($servers)) {
            $servers = [
                [
                    'host'   => 'localhost',
                    'port'   => 11211,
                    'weight' => 1
                ]
            ];
        }

        $this->memcached = new Memcached();
        $this->memcached->setOption(Memcached::OPT_COMPRESSION, 20000);

        if ($keyPrefix !== null) {
            $this->keyPrefix = $keyPrefix;
            $this->memcached->setOption(Memcached::OPT_PREFIX_KEY, $keyPrefix);
        }
        if ($connectionTimeout !== null) {
            $this->memcached->setOption(Memcached::OPT_CONNECT_TIMEOUT, $connectionTimeout);
        }
        try {
            $this->memcached->addServers($servers);
        } catch (\Exception $e) {
            throw new \RuntimeException('Could not add memcached servers to pool');
        }
    }

    /**
     * Returns boolean on whether the storage contains a value which has been set by $name
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        $this->validateKey($name);
        return ($this->memcached->get($name) !== false);
    }

    /**
     * Returns a value which has been set by $name
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        $this->validateKey($name);
        return unserialize($this->memcached->get($name));
    }

    /**
     * Sets a value into the storage with a key of $name
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public function set($name, $value)
    {
        $this->validateKey($name);

        if ($value === null) {
            throw new \InvalidArgumentException('Cannot set null into Memcached storage');
        }

        return $this->memcached->set($name, serialize($value), $this->ttl);
    }

    /**
     * Validates a memcached key
     * @param string $key
     */
    protected function validateKey($key)
    {
        if (!preg_match('/^[a-z0-9\-]+$/i', $key)) {
            throw new \InvalidArgumentException("Memcached key $key is not valid");
        }
        if (strlen($key) + strlen($this->keyPrefix) > 250) {
            throw new \InvalidArgumentException("Key $key plus prefix is too long");
        }
    }

}