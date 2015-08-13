<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class Flag
{

    /**
     * @var int $id
     * @MarshallProperty(name="id", type="int")
     */
    public $id;

    /**
     * @var string $name;
     * @MarshallProperty(name="name", type="string")
     */
    public $name;

    /**
     * @var boolean $value
     * @MarshallProperty(name="value", type="boolean")
     */
    public $value;

}
