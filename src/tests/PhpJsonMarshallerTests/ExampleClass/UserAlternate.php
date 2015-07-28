<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallConfig;
use PhpJsonMarshaller\Annotations\MarshallProperty;

/**
 * A basic user class to set an iType, Object and Array directly. Ignore unknown properties
 * @MarshallConfig(ignoreUnknown=true)
 */
class UserAlternate
{

    /**
     * @var int $id
     * @MarshallProperty(name="id", type="int")
     */
    public $id;

    /**
     * @var Address
     * @MarshallProperty(name="address", type="\PhpJsonMarshallerTests\ExampleClass\Address")
     */
    public $address;

    /**
     * @var Flag[]
     * @MarshallProperty(name="flags", type="\PhpJsonMarshallerTests\ExampleClass\Flag[]")
     */
    public $flags;

}
