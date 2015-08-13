<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class PropertyMissing
{

    /**
     * @var int $id
     * @MarshallProperty(name="id")
     */
    public $id;

}
