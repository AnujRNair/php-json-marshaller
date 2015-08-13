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
 * Class MethodComplex
 * @package PhpJsonMarshallerTests\ExampleClass
 */
class MethodConstructor
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
     * @param int $id
     * @param float $rank
     * @MarshallCreator({@MarshallProperty(name="id", type="int"), @MarshallProperty(name="rank", type="float")})
     */
    public function __construct($id, $rank)
    {
        $this->id = $id;
        $this->rank = $rank;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getRank()
    {
        return $this->rank;
    }

}
