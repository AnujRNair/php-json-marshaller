<?php

namespace PhpJsonMarshaller\Annotations;

/**
 * Class MarshallCreator
 * @package PhpJsonMarshaller\Annotations
 * @Annotation
 */
class MarshallCreator implements iMarshallAnnotation
{

    /**
     * @var \PhpJsonMarshaller\Annotations\MarshallProperty[]
     */
    public $params;

    /**
     * @return \PhpJsonMarshaller\Annotations\MarshallProperty[]
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Verifies an annotation is valid
     * @param array $params a list of params to validate, if needed
     * @return bool
     */
    public function validate($params = [])
    {
        $count = count($this->getParams());
        if ($count === 0) {
            throw new \InvalidArgumentException('@MarshallCreator annotation must be instantiated with an array of @MarshallProperty annotations');
        }
        if ($count < $params['noRequiredParams']) {
            throw new \InvalidArgumentException('@MarshallCreator annotation has fewer params that which is required');
        }
        foreach ($this->getParams() as $param) {
            $param->validate();
        }
        return true;
    }

}