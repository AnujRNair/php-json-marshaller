<?php

namespace PhpJsonMarshaller\Annotations;

/**
 * An annotation to set the config on a particular class
 * Class MarshallConfig
 * @package PhpJsonMarshaller\Annotations
 * @Annotation
 */
class MarshallConfig
{
    /**
     * A property to allow us to skip unknown properties in a JSON string
     * @var boolean $ignoreUnknown
     */
    public $ignoreUnknown;

    /**
     * Returns true if the class has the IgnoreUnknown property set
     * @return boolean
     */
    public function hasIgnoreUnknown()
    {
        return $this->ignoreUnknown !== null;
    }

    /**
     * Returns true if the class allows us to ignore unknown properties
     * @return boolean
     */
    public function canIgnoreUnknown()
    {
        return $this->ignoreUnknown;
    }

    /**
     * Sets the ignore unknown property
     * @param boolean $ignoreUnknown if we can ignore unknown properties coming
     * from the JSON string
     */
    public function setIgnoreUnknown($ignoreUnknown)
    {
        $this->ignoreUnknown = $ignoreUnknown;
    }

}
