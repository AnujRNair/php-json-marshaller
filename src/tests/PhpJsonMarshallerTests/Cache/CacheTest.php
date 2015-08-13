<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\Cache;

use PhpJsonMarshaller\Cache\Cache;
use PhpJsonMarshaller\Cache\Storage\InMemoryStorage;
use PhpJsonMarshaller\Decoder\ClassDecoder;
use PhpJsonMarshaller\Reader\DoctrineAnnotationReader;

class CacheTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var ClassDecoder
     */
    protected $decoder;

    public function setUp()
    {
        $this->cache = new Cache(new InMemoryStorage());
        $this->decoder = new ClassDecoder(new DoctrineAnnotationReader());
    }

    public function testSetAndGetFromCache()
    {
        $classObject = $this->decoder->decodeClass('\PhpJsonMarshallerTests\ExampleClass\User');
        $this->cache->setClass('\PhpJsonMarshallerTests\ExampleClass\User', $classObject);

        $fromCache = $this->cache->getClass('\PhpJsonMarshallerTests\ExampleClass\User');

        $this->assertEquals(count($classObject->getProperties()), count($fromCache->getProperties()));
        $this->assertTrue($fromCache->hasProperty('id'));
        $this->assertTrue($fromCache->hasProperty('firstName'));
        $this->assertTrue($fromCache->hasProperty('active'));
        $this->assertTrue($fromCache->hasProperty('firstLogin'));
        $this->assertTrue($fromCache->hasProperty('rank'));
        $this->assertTrue($fromCache->hasProperty('address'));
        $this->assertTrue($fromCache->hasProperty('flags'));
        $this->assertTrue($fromCache->hasProperty('loginDates'));
    }

    /**
     * @expectedException \PhpJsonMarshaller\Exception\CacheCollisionException
     */
    public function testExceptionOnCacheCollision()
    {
        $classObject = $this->decoder->decodeClass('\PhpJsonMarshallerTests\ExampleClass\User');
        $this->cache->setClass('\PhpJsonMarshallerTests\ExampleClass\User', $classObject);
        $this->cache->setClass('\PhpJsonMarshallerTests\ExampleClass\User', $classObject);
    }

}
