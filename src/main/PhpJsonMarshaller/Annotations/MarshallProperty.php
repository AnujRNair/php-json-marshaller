<?php

namespace PhpJsonMarshaller\Annotations;

/**
 * An annotation to inform the marshaller what property to act on and what it's
 * expected type is
 * Class MarshallProperty
 * @package PhpJsonMarshaller\Annotations
 * @Annotation
 */
class MarshallProperty implements iMarshallAnnotation
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
     * Get the expected type of the JSON property
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Verifies an annotation is valid
     * @param array $params a list of params to validate, if needed
     * @return bool
     */
    public function validate($params = [])
    {
        if ($this->getName() === null || $this->getType() === null) {
            throw new \InvalidArgumentException('@MarshallProperty needs a name and type defined');
        }
        return true;
    }

}