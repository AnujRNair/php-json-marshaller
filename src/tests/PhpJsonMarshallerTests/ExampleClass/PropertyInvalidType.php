<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
