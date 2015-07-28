<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class PropertyInvalidType
{

    /**
     * @var \PhpJsonMarshallerTests\ExampleClass\Flag[int] $id
     * @MarshallProperty(name="id", type="\PhpJsonMarshallerTests\ExampleClass\Flag[int]")
     */
    public $id;

}
