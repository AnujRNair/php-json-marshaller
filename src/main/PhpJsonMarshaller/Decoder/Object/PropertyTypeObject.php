<?php

namespace PhpJsonMarshaller\Decoder\Object;

use PhpJsonMarshaller\Type\iType;

/**
 * Class PropertyTypeObject
 * @package PhpJsonMarshaller\Decoder\Object
 */
class PropertyTypeObject
{

    const TYPE_SCALAR = 'scalar';
    const TYPE_OBJECT = 'object';
    const TYPE_ARRAY = 'array';

    /**
     * The type of variable the property is, defined by one of the consts above
     * @var string $type
     */
    protected $type;

    /**
     * Hold an iType class to encode/decode the type
     * In the case of an object, it holds the object string name
     * In the case of an array, it holds information on the type the array is, and a class to encode/decode the type
     * @var mixed $value
     */
    protected $value;

    /**
     * @param string $type
     * @param mixed $value
     */
    public function __construct(
        $type,
        $value
    )
    {
        $this->validate($type, $value);
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Validate that the parameters are valid
     * @param string $type
     * @param mixed $value
     */
    protected function validate($type, $value)
    {
        // Check the type
        if (!in_array($type, [self::TYPE_SCALAR, self::TYPE_OBJECT, self::TYPE_ARRAY])) {
            if (is_object($type) || is_array($type)) {
                throw new \InvalidArgumentException("Invalid type passed to the PropertyTypeObject class");
            }
            throw new \InvalidArgumentException("Type: $type is not a valid argument for the PropertyTypeObject class");
        }

        // Check the value is an iType (scalar), a PropertyTypeObject (array), or a string (objects)
        if (!($value instanceof iType || $value instanceof PropertyTypeObject || is_string($value))) {
            if (is_object($value) || is_array($value)) {
                throw new \InvalidArgumentException("Invalid type passed to the PropertyTypeObject class");
            }
            throw new \InvalidArgumentException("Value $value is not a valid argument for the PropertyTypeObject class");
        }
    }

    /**
     * Returns the type this Property is
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the value of the property
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

}
