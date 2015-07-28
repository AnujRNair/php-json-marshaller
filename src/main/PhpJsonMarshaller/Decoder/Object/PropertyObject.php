<?php

namespace PhpJsonMarshaller\Decoder\Object;

/**
 * Hold decoded information about a particular property
 * Class PropertyObject
 * @package PhpJsonMarshaller\Decoder\Object
 */
class PropertyObject
{

    /**
     * The value from the name param in the MarshallProperty annotation
     * @var string $jsonName
     */
    protected $jsonName;

    /**
     * The value from the type param in the MarshallProperty annotation
     * @var string $jsonType
     */
    protected $jsonType;

    /**
     * The name of the property from the decoded class to allow direct getting/setting
     * @var string $direct
     */
    protected $direct = false;

    /**
     * The name of the method from the decoded class to use as a getter
     * @var string $getter
     */
    protected $getter = null;

    /**
     * The name of the method from the decoded class to user as a setter
     * @var string $setter
     */
    protected $setter = null;

    /**
     * @param string $jsonName the value of the name param from the MarshallProperty annotation
     * @param string $jsonType the value of the type param from the MarshallProperty annotation
     * @param string $direct the name of the property from the decoded class to allow direct getting/setting
     * @param string $getter the name of the method from the decoded class to use as a getter
     * @param string $setter the name of the method from the decoded class to user as a setter
     */
    public function __construct(
        $jsonName = null,
        $jsonType = null,
        $direct = null,
        $getter = null,
        $setter = null
    )
    {
        $this->jsonName = $jsonName;
        $this->jsonType = $jsonType;
        $this->direct = $direct;
        $this->getter = $getter;
        $this->setter = $setter;
    }

    /**
     * Returns boolean on whether the json name has been set
     * @return bool
     */
    public function hasJsonName()
    {
        return $this->jsonName !== null;
    }

    /**
     * Returns the json name
     * @return string
     */
    public function getJsonName()
    {
        return $this->jsonName;
    }

    /**
     * Sets the json name
     * @param string $jsonName
     */
    public function setJsonName($jsonName)
    {
        $this->jsonName = $jsonName;
    }

    /**
     * Returns boolean on whether the json type has been set
     * @return bool
     */
    public function hasJsonType()
    {
        return $this->jsonType !== null;
    }

    /**
     * Returns the json type
     * @return string
     */
    public function getJsonType()
    {
        return $this->jsonType;
    }

    /**
     * Sets the json type
     * @param string $jsonType
     */
    public function setJsonType($jsonType)
    {
        $this->jsonType = $jsonType;
    }

    /**
     * Returns boolean on whether a direct getter/setter has been set
     * @return bool
     */
    public function hasDirect()
    {
        return $this->direct !== null;
    }

    /**
     * Returns the direct getter/setter name
     * @return string
     */
    public function getDirect()
    {
        return $this->direct;
    }

    /**
     * Sets the direct getter/setter name
     * @param string $direct
     */
    public function setDirect($direct)
    {
        $this->direct = $direct;
    }

    /**
     * Returns boolean on whether a method to get has been set
     * @return bool
     */
    public function hasGetter()
    {
        return $this->getter !== null;
    }

    /**
     * Gets the getter method name
     * @return string
     */
    public function getGetter()
    {
        return $this->getter;
    }

    /**
     * Sets the getter method name
     * @param string $getter
     */
    public function setGetter($getter)
    {
        $this->getter = $getter;
    }

    /**
     * Returns boolean on whether a method to set has been set
     * @return bool
     */
    public function hasSetter()
    {
        return $this->setter !== null;
    }

    /**
     * Gets the setter method name
     * @return string
     */
    public function getSetter()
    {
        return $this->setter;
    }

    /**
     * Sets the setter method name
     * @param string $setter
     */
    public function setSetter($setter)
    {
        $this->setter = $setter;
    }
}