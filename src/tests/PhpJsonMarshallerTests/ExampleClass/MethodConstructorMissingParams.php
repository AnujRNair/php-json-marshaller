<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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