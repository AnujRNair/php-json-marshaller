<?php

namespace PhpJsonMarshallerTests\ExampleClass;

class MethodNone
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}
