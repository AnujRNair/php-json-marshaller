<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
