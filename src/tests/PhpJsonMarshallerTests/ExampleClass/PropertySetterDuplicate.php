<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class PropertySetterDuplicate
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @param int $id
     * @MarshallProperty(name="id", type="int")
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param int $id
     * @MarshallProperty(name="id", type="int")
     */
    public function setIdDuplicate($id)
    {
        $this->id = $id;
    }

}
