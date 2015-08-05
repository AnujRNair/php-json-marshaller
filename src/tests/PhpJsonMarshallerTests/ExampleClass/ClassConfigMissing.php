<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallConfig;
use PhpJsonMarshaller\Annotations\MarshallProperty;

/**
 * A class where the config is incorrectly configured
 * @MarshallConfig()
 */
class ClassConfigMissing
{

    /**
     * @var int $id
     * @MarshallProperty(name="id", type="int")
     */
    public $id;

}
