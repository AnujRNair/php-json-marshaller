<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class Flag
{

    /**
     * @var int $id
     * @MarshallProperty(name="id", type="int")
     */
    public $id;

    /**
     * @var string $name;
     * @MarshallProperty(name="name", type="string")
     */
    public $name;

    /**
     * @var boolean $value
     * @MarshallProperty(name="value", type="boolean")
     */
    public $value;

}
