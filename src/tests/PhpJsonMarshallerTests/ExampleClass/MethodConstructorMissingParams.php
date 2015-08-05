<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallCreator;
use PhpJsonMarshaller\Annotations\MarshallProperty;

/**
 * Class MethodConstructorMissingParams
 * @package PhpJsonMarshallerTests\ExampleClass
 */
class MethodConstructorMissingParams
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var float $rank
     */
    protected $rank;

    /**
     * @param $id
     * @param $rank
     * @MarshallCreator({@MarshallProperty(name="id", type="int")})
     */
    public function __construct($id, $rank)
    {
        $this->id = $id;
        $this->rank = $rank;
    }

}