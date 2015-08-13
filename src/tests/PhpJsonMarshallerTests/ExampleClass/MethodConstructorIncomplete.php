<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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