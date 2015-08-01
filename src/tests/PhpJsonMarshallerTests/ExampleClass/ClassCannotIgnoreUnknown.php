<?php

namespace PhpJsonMarshallerTests\ExampleClass;

use PhpJsonMarshaller\Annotations\MarshallConfig;
use PhpJsonMarshaller\Annotations\MarshallProperty;

/**
 * A class where nothing can be ignored
 * @MarshallConfig(ignoreUnknown=false)
 */
class ClassCannotIgnoreUnknown
{

    /**
     * @var int $id
     * @MarshallProperty(name="id", type="int")
     */
    public $id;

    /**
     * @var boolean $active
     */
    protected $active;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @MarshallProperty(name="active", type="boolean")
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @MarshallProperty(name="active", type="boolean")
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @MarshallProperty(name="name", type="string")
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @MarshallProperty(name="name", type="string")
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}
