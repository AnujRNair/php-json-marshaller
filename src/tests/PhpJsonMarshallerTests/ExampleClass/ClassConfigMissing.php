<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
