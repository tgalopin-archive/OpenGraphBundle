<?php

namespace Tga\OpenGraphBundle\Tests\Mock;

use Tga\OpenGraphBundle\Document\OpenGraphDocument;
use Tga\OpenGraphBundle\Map\OpenGraphMapInterface;
use Tga\OpenGraphBundle\OpenGraph;
use Tga\OpenGraphBundle\Routing\RouterAware;

class Map extends RouterAware implements OpenGraphMapInterface
{
    /**
     * @param OpenGraphDocument $document
     * @param object $entity
     */
    public function map(OpenGraphDocument $document, $entity)
    {
        $document->append(OpenGraph::OG_TITLE, $entity->name);
    }

    /**
     * @param object $entity
     * @return bool
     */
    public function supports($entity)
    {
        return $entity instanceof \stdClass && ! empty($entity->name);
    }
}