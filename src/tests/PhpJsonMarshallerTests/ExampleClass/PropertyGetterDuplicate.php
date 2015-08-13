<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallProperty;

class PropertyGetterDuplicate
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @return int
     * @MarshallProperty(name="id", type="int")
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     * @MarshallProperty(name="id", type="int")
     */
    public function getIdDuplicate()
    {
        return $this->id;
    }

}
