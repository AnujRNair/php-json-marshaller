<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallCreator;
use PhpJsonMarshaller\Annotations\MarshallProperty;

/**
 * Class MethodConstructorMissingParams
 * @package PhpJsonMarshallerTests\ExampleClass
 */
class MethodConstructorPropertyIncomplete
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
     * @MarshallCreator({@MarshallProperty(name="id"), @MarshallProperty(name="rank", type="float")})
     */
    public function __construct($id, $rank)
    {
        $this->id = $id;
        $this->rank = $rank;
    }

}