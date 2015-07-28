<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class PropertyGetterDuplicate
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @return int
     * @MarshallProperty(name="id", type="int")
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     * @MarshallProperty(name="id", type="int")
     */
    public function getIdDuplicate()
    {
        return $this->id;
    }

}
