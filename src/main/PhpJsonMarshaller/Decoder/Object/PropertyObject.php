<?php

namespace PhpJsonMarshaller\Decoder\Object;

use PhpJsonMarshaller\Decoder\Object\PropertyTypeObject as PTO;
use PhpJsonMarshaller\Exception\InvalidTypeException;
use PhpJsonMarshaller\Type\DateTimeType;
use PhpJsonMarshaller\Type\FloatType;
use PhpJsonMarshaller\Type\StringType;
use PhpJsonMarshaller\Type\BoolType;
use PhpJsonMarshaller\Type\IntType;

/**
 * Hold decoded information about a particular property
 * Class PropertyObject
 * @package PhpJsonMarshaller\Decoder\Object
 */
class PropertyObject
{

    /**
     * The value from the name param in the MarshallProperty annotation
     * @var string $annotationName
     */
    protected $annotationName;

    /**
     * The value from the type param in the MarshallProperty annotation
     * @var string $annotationType
     */
    protected $annotationType;

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
     * A PropertyTypeObject instance consisting of a const identifier, and a calculated variable type
     * @var PropertyTypeObject $propertyType
     */
    protected $propertyType;

    /**
     * @param string $annotationName the value of the name param from the MarshallProperty annotation
     * @param string $annotationType the value of the type param from the MarshallProperty annotation
     * @param string $direct the name of the property from the decoded class to allow direct getting/setting
     * @param string $getter the name of the method from the decoded class to use as a getter
     * @param string $setter the name of the method from the decoded class to user as a setter
     */
    public function __construct(
        $annotationName,
        $annotationType,
        $direct = null,
        $getter = null,
        $setter = null
    )
    {
        $this->annotationName = $annotationName;
        $this->annotationType = $annotationType;
        $this->direct = $direct;
        $this->getter = $getter;
        $this->setter = $setter;

        $this->propertyType = $this->createType($this->annotationType);
    }

    /**
     * Returns boolean on whether the annotation name param has been set
     * @return bool
     */
    public function hasAnnotationName()
    {
        return $this->annotationName !== null;
    }

    /**
     * Returns the annotation name param
     * @return string
     */
    public function getAnnotationName()
    {
        return $this->annotationName;
    }

    /**
     * Returns boolean on whether the annotation type param has been set
     * @return bool
     */
    public function hasAnnotationType()
    {
        return $this->annotationType !== null;
    }

    /**
     * Returns the annotation type param
     * @return string
     */
    public function getAnnotationType()
    {
        return $this->annotationType;
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

    /**
     * Gets the type of this Property
     * @return PropertyTypeObject
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * Creates a descriptor and a typed object from a string type
     * @param string $type the type
     * @return array(PropertyTypeObject::TYPE_, iType)
     * @throws InvalidTypeException
     */
    protected function createType($type)
    {
        // Remove leading slash, if any
        $type = ltrim($type, '\\');
        // Check for array
        $pos = strrpos($type, '[');

        if ($pos === false) {
            switch (strtolower($type)) {
                case 'integer':
                case 'int':
                    return new PTO(PTO::TYPE_PRIMITIVE, new IntType());
                case 'boolean':
                case 'bool':
                    return new PTO(PTO::TYPE_PRIMITIVE, new BoolType());
                case 'string':
                    return new PTO(PTO::TYPE_PRIMITIVE, new StringType());
                case 'float':
                    return new PTO(PTO::TYPE_PRIMITIVE, new FloatType());
                case 'datetime':
                    return new PTO(PTO::TYPE_PRIMITIVE, new DateTimeType());
                default:
                    // Guessing it's an object
                    return new PTO(PTO::TYPE_OBJECT, $type);
            }
        }

        if ($type[$pos + 1] !== ']') {
            throw new InvalidTypeException('Cannot nest a type inside of an array');
        }

        // guessing it's an array
        return new PTO(PTO::TYPE_ARRAY, $this->createType(substr($type, 0, strpos($type, '['))));
    }
}