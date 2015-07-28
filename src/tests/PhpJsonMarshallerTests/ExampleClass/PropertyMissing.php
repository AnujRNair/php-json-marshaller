<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class PropertyMissing
{

    /**
     * @var int $id
     * @MarshallProperty(name="id")
     */
    public $id;

}
