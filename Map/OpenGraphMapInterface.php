<?php

namespace Tga\OpenGraphBundle\Map;

use Tga\OpenGraphBundle\Document\OpenGraphDocument;

interface OpenGraphMapInterface
{
    /**
     * @param OpenGraphDocument $document
     * @param object $entity
     */
    public function map(OpenGraphDocument $document, $entity);

    /**
     * @param object $entity
     * @return bool
     */
    public function supports($entity);
}