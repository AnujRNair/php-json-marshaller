<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshaller\Decoder\Object;

/**
 * Holds decoded information about a particular class and it's properties
 * Class ClassObject
 * @package PhpJsonMarshaller\Decoder\Object
 */
class ClassObject
{

    /**
     * An array of decoded properties which exist in the class
     * @var PropertyObject[] $properties
     */
    protected $properties = array();

    /**
     * A boolean on whether we're allowed to ignore unknown properties coming
     * from the JSON string
     * @var bool $ignoreUnknown
     */
    protected $ignoreUnknown = true;

    /**
     * An aarray of decoded parameters which are needed to instantiate the class
     * @var PropertyObject[] $constructorParams
     */
    protected $constructorParams = array();


    /**
     * Return all PropertyObjects from the class
     * @return PropertyObject[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set the decoded PropertyObjects into the class object
     * @param PropertyObject[] $properties an array of PropertyObject with the
     * MarshallProperty name param as each array key
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * Get a specific PropertyObject by key
     * @param string $key the MarshallProperty name param
     * @return PropertyObject
     */
    public function getProperty($key)
    {
        return $this->properties[$key];
    }

    /**
     * Check if the class has a specific PropertyObject by key
     * @param string $key the MarshallProperty name param
     * @return bool
     */
    public function hasProperty($key)
    {
        return isset($this->properties[$key]);
    }

    /**
     * Boolean on whether we are allowed to ignore unknown properties coming
     * from thr JSON string
     * @return boolean
     */
    public function canIgnoreUnknown()
    {
        return $this->ignoreUnknown;
    }

    /**
     * Sets whether we are allowed to ignore unknown properties in this class
     * @param boolean $ignoreUnknown
     */
    public function setIgnoreUnknown($ignoreUnknown)
    {
        $this->ignoreUnknown = $ignoreUnknown;
    }

    /**
     * @return PropertyObject[]
     */
    public function getConstructorParams()
    {
        return $this->constructorParams;
    }

    /**
     * @param PropertyObject[] $constructorParams
     */
    public function setConstructorParams($constructorParams)
    {
        $this->constructorParams = $constructorParams;
    }
}
