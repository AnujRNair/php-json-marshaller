<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\Cache\Storage;

use PhpJsonMarshaller\Cache\Storage\InMemoryStorage;

class InMemoryStorageTest extends \PHPUnit_Framework_TestCase
{

    /** @var InMemoryStorage */
    private $inMemory;

    public function setUp()
    {
        $this->inMemory = new InMemoryStorage();
    }

    public function testGetNonExistentKey()
    {
        $result = $this->inMemory->get('php-json-marshaller-phpunit-memcached-storage-test-test-get-non-existent-key');
        $this->assertFalse($result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNullValue()
    {
        $this->inMemory->set('php-json-marshaller-phpunit-memcached-storage-test-test-set-null', null);
    }

    public function testSetAndGetBasicVariable()
    {
        $this->inMemory->set('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-get-basic-variable', 1);
        $result = $this->inMemory->get('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-get-basic-variable');
        $this->assertSame(1, $result);
    }

    public function testSetAndHasBasicVariable()
    {
        $this->inMemory->set('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-has-basic-variable', 1);
        $result = $this->inMemory->has('php-json-marshaller-phpunit-memcached-storage-test-test-set-and-has-basic-variable');
        $this->assertTrue($result);
    }

}
