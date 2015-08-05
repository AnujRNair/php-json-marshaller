<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallCreator;

/**
 * Class MethodConstructorIncomplete
 * @package PhpJsonMarshallerTests\ExampleClass
 */
class MethodConstructorIncomplete
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @param $id
     * @MarshallCreator()
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

}