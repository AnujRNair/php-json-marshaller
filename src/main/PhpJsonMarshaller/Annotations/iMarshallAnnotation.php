<?php

namespace PhpJsonMarshaller\Annotations;

/**
 * Interface iMarshallAnnotation
 * @package PhpJsonMarshaller\Annotations
 */
interface iMarshallAnnotation
{

    /**
     * Verifies an annotation is valid
     * @param array $params a list of params to validate, if needed
     * @return bool
     */
    public function validate($params = []);

}
