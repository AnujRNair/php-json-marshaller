<?php

/*
 * Copyright (c) 2015 Anuj Nair
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpJsonMarshaller\Reader;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Class DoctrineAnnotationReader
 * @package PhpJsonMarshaller\Reader
 */
class DoctrineAnnotationReader extends AnnotationReader
{

    /**
     * Creates a basic instance of the AnnotationReader and sets some namespaces for autoloading
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct()
    {
        parent::__construct();
        AnnotationRegistry::registerAutoloadNamespace('PhpJsonMarshaller', [__DIR__ . '/../../']);
        AnnotationRegistry::registerAutoloadNamespace('\PhpJsonMarshaller', [__DIR__ . '/../../']);
    }

}
