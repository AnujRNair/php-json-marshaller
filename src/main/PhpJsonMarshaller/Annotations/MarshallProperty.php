<?php

namespace PhpJsonMarshaller\Annotations;

/**
 * An annotation to inform the marshaller what property to act on and what it's
 * expected type is
 * Class MarshallProperty
 * @package PhpJsonMarshaller\Annotations
 * @Annotation
 */
class MarshallProperty
{

    /**
     * Marshall: What to name the JSON key
     * UnMarshall: What the name of the JSON key is
     * @var string $name
     */
    public $name;

    /**
     * Marshall: Allows the marshaller to convert this type to a string
     * UnMarshall: Tells the marshaller what type to validate and set this variable as
     * @var string $type
     */
    public $type;

    /**
     * Get the name of the JSON key
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the JSON key
     * @param string $name the value of the name param in the annotation
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the expected type of the JSON property
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the expected type of the JSON property
     * @param string $type the value of the type param in the annotation
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}