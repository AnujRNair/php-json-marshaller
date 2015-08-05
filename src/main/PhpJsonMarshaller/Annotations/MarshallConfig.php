<?php

namespace PhpJsonMarshaller\Annotations;

/**
 * An annotation to set the config on a particular class
 * Class MarshallConfig
 * @package PhpJsonMarshaller\Annotations
 * @Annotation
 */
class MarshallConfig implements iMarshallAnnotation
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
     * Verifies an annotation is valid
     * @param array $params a list of params to validate, if needed
     * @return bool
     */
    public function validate($params = [])
    {
        if (!$this->hasIgnoreUnknown()) {
            throw new \InvalidArgumentException('@MarshallConfig needs an ignoreUnknown property set');
        }
        return true;
    }

}
