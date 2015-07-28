<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class MethodMissing
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @return int
     * @MarshallProperty(type="int")
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @MarshallProperty(name="id")
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}
