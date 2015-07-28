<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class Address
{

    /**
     * @var int $id
     * @MarshallProperty(name="id", type="int")
     */
    public $id;

    /**
     * @var string $street
     * @MarshallProperty(name="street", type="string")
     */
    public $street;

    /**
     * @var string $state
     * @MarshallProperty(name="state", type="string")
     */
    public $state;

    /**
     * @var int $zip
     * @MarshallProperty(name="zipcode", type="int")
     */
    public $zip;

}