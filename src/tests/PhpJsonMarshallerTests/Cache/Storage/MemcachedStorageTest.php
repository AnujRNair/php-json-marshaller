<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\Cache\Storage;

use PhpJsonMarshaller\Cache\Storage\MemcachedStorage;

class MemcachedStorageTest extends \PHPUnit_Framework_TestCase
{
    /** @var MemcachedStorage */
    private $memcached;

    public function setUp()
    {
        $this->memcached = new MemcachedStorage([], 300, 'php-json-marshaller', 5);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidServers()
    {
        new MemcachedStorage(['Invalid']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMemcachedKey()
    {
        $this->memcached->set('key space', 0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMemcachedKeyTooLong()
    {
        $this->memcached->set('php-json-marshaller-phpunit-memcached-storage-test-test-memcached-key-too-long--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer--buffer', 0);
    }

    public function testSetAndGetBasicVariable()
    {
        $this->memcached->set('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-get-basic-variable', 1);
        $result = $this->memcached->get('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-get-basic-variable');
        $this->assertSame(1, $result);
    }

    public function testSetAndHasBasicVariable()
    {
        $this->memcached->set('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-has-basic-variable', 1);
        $result = $this->memcached->has('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-has-basic-variable');
        $this->assertTrue($result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNull()
    {
        $this->memcached->set('php-json-marshaller-phpunit-memcached-storage-test-test-set-null', null);
    }

    public function testGetNonExistentKey()
    {
        $result = $this->memcached->get('php-json-marshaller-phpunit-memcached-storage-test-test-get-non-existent-key');
        $this->assertFalse($result);
    }

}
